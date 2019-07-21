<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\City;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityTest extends TestCase
{
    use RefreshDatabase;

    public $graphQLEndpoint = 'api/public';
    public $fields = [
        'id',
        'lat',
        'lng',
        'name',
        'state' => [
            'id',
            'code',
            'name',
            'country' => ['id', 'code', 'name']
        ]
    ];

    public function test_can_get_city(): void
    {
        /** @var Collection $city */
        $city     = factory(City::class)->create();
        $response = $this->query('cities', ['data' => $this->fields]);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.cities.data');
        $this->checkStruct($response, 'cities', $this->fields);
        $response->assertJson([
            'data' => [
                'cities' => [
                    'data' => [
                        $city->makeHidden('state_id')->toArray()
                    ]
                ]
            ]
        ]);
    }

    public function test_can_get_city_filterable(): void
    {
        /** @var Collection $city */
        $city = factory(City::class, 10)->create();

        foreach (Arr::except($this->fields, ['state', 1, 2]) as $field) {
            $response    = $this->query(
                'cities',
                ['filter' => [$field => $city[5]->$field]],
                ['data' => $this->fields]
            );
            $orderedData = $city[5]->makeHidden('state_id')->toArray();

            $response->assertStatus(200)
                ->assertJsonCount(1, 'data.cities.data');
            $this->checkStruct($response, 'cities', $this->fields);
            $response->assertJson([
                'data' => [
                    'cities' => [
                        'data' => [
                            sort($orderedData)
                        ]
                    ]
                ]
            ]);
        }
    }

    private function sortable(string $direction, array $fields) :void
    {
        /** @var Collection $city */
        $city = factory(City::class, 10)->create();

        foreach ($fields as $field) {
            $query    = "{
                    cities(sort: {sort_by: \"$field\", type: {$direction}}){
                        data {
                            id
                            lat
                            lng
                            name
                            state {
                                id
                                code
                                name
                                country {
                                    id
                                    code
                                    name
                                }
                            }
                        }
                    }
                }";
            $response = $this->graphql($query);

            $sorted = $direction === 'asc' ? $city->sortBy($field) : $city->sortByDesc($field);
            $orderedData = $sorted->makeHidden('state_id')->toArray();

            $response->assertStatus(200)
                ->assertJsonCount(10, 'data.cities.data');
            $this->checkStruct($response, 'cities', $this->fields);
            $response->assertJson([
                'data' => [
                    'cities' => [
                        'data' => ksort($orderedData)
                    ]
                ]
            ]);
        }
    }

    public function test_can_get_city_sortable_asc(): void
    {
        $this->sortable('asc', Arr::except($this->fields, ['state']));
    }

    public function test_can_get_city_sortable_desc(): void
    {
        $this->sortable('desc', Arr::except($this->fields, ['state']));
    }
}
