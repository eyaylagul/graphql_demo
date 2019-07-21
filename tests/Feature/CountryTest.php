<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CountryTest extends TestCase
{
    use RefreshDatabase;

    public $graphQLEndpoint = 'api/public';
    public $fields = ['id', 'code', 'name'];

    public function test_can_get_country(): void
    {
        /** @var Collection $country */
        $country  = factory(Country::class)->create();
        $response = $this->query('countries', ['data' => $this->fields]);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.countries.data');
        $this->checkStruct($response, 'countries', $this->fields);
        $response->assertJson([
            'data' => [
                'countries' => [
                    'data' => [
                        $country->toArray()
                    ]
                ]
            ]
        ]);
    }

    public function test_can_get_country_filterable(): void
    {
        $country = factory(Country::class, 10)->create();
        foreach ($this->fields as $field) {
            $response = $this->query(
                'countries',
                ['filter' => [$field => $country[5]->$field]],
                ['data' => $this->fields]
            );


            $response->assertStatus(200)
                ->assertJsonCount(1, 'data.countries.data');
            $this->checkStruct($response, 'countries', $this->fields);
            $response->assertJson([
                'data' => [
                    'countries' => [
                        'data' => [
                            ['id' => $country[5]->id, 'code' => $country[5]->code, 'name' => $country[5]->name]
                        ]
                    ]
                ]
            ]);
        }
    }


    private function sortable(string $direction, array $fields) :void
    {
        /** @var Collection $country */
        $country = factory(Country::class, 10)->create();

        foreach ($fields as $field) {
            $query    = "{
                    countries(sort: {sort_by: \"$field\", type: {$direction}}){
                        data {
                            id
                            code
                            name
                        }
                    }
                }";
            $response = $this->graphql($query);

            $countriesSorted = $direction === 'asc' ? $country->sortBy($field) : $country->sortByDesc($field);
            $orderedData     = $countriesSorted->toArray();

            $response->assertStatus(200)
                ->assertJsonCount(10, 'data.countries.data');
            $this->checkStruct($response, 'countries', $this->fields);
            $response->assertJson([
                'data' => [
                    'countries' => [
                        'data' => ksort($orderedData)
                    ]
                ]
            ]);
        }
    }

    public function test_can_get_country_sortable_asc(): void
    {
        $this->sortable('asc', $this->fields);
    }

    public function test_can_get_country_sortable_desc(): void
    {
        $this->sortable('desc', $this->fields);
    }
}
