<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\CityAlias;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CityAliasTest extends TestCase
{
    use RefreshDatabase;

    public $graphQLEndpoint = 'api/public';
    public $fields = [
        'id',
        'name',
        'city' => [
            'id',
            'name',
            'lat',
            'lng',
            'state' => [
                'id',
                'code',
                'name',
                'country' => ['id', 'code', 'name']
            ]
        ]
    ];

    public function test_can_get_city_alias(): void
    {
        /** @var Collection $alias */
        $alias     = factory(CityAlias::class)->create();
        $response = $this->query('city_aliases', ['data' => $this->fields]);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.city_aliases.data');
        $this->checkStruct($response, 'city_aliases', $this->fields);
        $response->assertJson([
            'data' => [
                'city_aliases' => [
                    'data' => [
                        $alias->makeHidden('city_id')->toArray()
                    ]
                ]
            ]
        ]);
    }

    public function test_can_get_city_filterable(): void
    {
        /** @var Collection $alias */
        $alias = factory(CityAlias::class, 10)->create();

        foreach (Arr::except($this->fields, ['city']) as $field) {
            $response    = $this->query(
                'city_aliases',
                ['filter' => [$field => $alias[5]->$field]],
                ['data' => $this->fields]
            );
            $orderedData = $alias[5]->makeHidden('city_id')->toArray();

            $response->assertStatus(200)
                ->assertJsonCount(1, 'data.city_aliases.data');
            $this->checkStruct($response, 'city_aliases', $this->fields);
            $response->assertJson([
                'data' => [
                    'city_aliases' => [
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
        /** @var Collection $alias */
        $alias = factory(CityAlias::class, 10)->create();

        foreach ($fields as $field) {
            $query    = "{
                    city_aliases(sort: {sort_by: \"$field\", type: {$direction}}){
                        data {
                            id
                            name
                            city {
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
                    }
                }";
            $response = $this->graphql($query);

            $sorted = $direction === 'asc' ? $alias->sortBy($field) : $alias->sortByDesc($field);
            $orderedData = $sorted->makeHidden('city_id')->toArray();

            $response->assertStatus(200)
                ->assertJsonCount(10, 'data.city_aliases.data');
            $this->checkStruct($response, 'city_aliases', $this->fields);
            $response->assertJson([
                'data' => [
                    'city_aliases' => [
                        'data' => ksort($orderedData)
                    ]
                ]
            ]);
        }
    }

    public function test_can_get_city_sortable_asc(): void
    {
        $this->sortable('asc', Arr::except($this->fields, ['city']));
    }

    public function test_can_get_city_sortable_desc(): void
    {
        $this->sortable('desc', Arr::except($this->fields, ['city']));
    }
}
