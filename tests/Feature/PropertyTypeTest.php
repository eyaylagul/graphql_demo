<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\PropertyType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PropertyTypeTest extends TestCase
{
    use RefreshDatabase;

    public $graphQLEndpoint = 'api/public';
    public $fields = ['id','name', 'description'];

    public function test_can_get_property_type(): void
    {
        /** @var Collection $propertyType */
        $propertyType  = factory(PropertyType::class)->create();
        $response = $this->query('property_types', ['data' => $this->fields]);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.property_types.data');
        $this->checkStruct($response, 'property_types', $this->fields);
        $response->assertJson([
            'data' => [
                'property_types' => [
                    'data' => [
                        $propertyType->toArray()
                    ]
                ]
            ]
        ]);
    }

    public function test_can_get_property_type_filterable(): void
    {
        $propertyType = factory(PropertyType::class, 10)->create();
        foreach ($this->fields as $field) {
            $response = $this->query(
                'property_types',
                ['filter' => [$field => $propertyType[5]->$field]],
                ['data' => $this->fields]
            );


            $response->assertStatus(200)
                ->assertJsonCount(1, 'data.property_types.data');
            $this->checkStruct($response, 'property_types', $this->fields);
            $response->assertJson([
                'data' => [
                    'property_types' => [
                        'data' => [
                            $propertyType[5]->toArray()
                        ]
                    ]
                ]
            ]);
        }
    }


    private function sortable(string $direction, array $fields) :void
    {
        /** @var Collection $propertyType */
        $propertyType = factory(PropertyType::class, 10)->create();

        foreach ($fields as $field) {
            $query    = "{
                    property_types(sort: {sort_by: \"$field\", type: {$direction}}){
                        data {
                            id
                            name
                            description
                        }
                    }
                }";
            $response = $this->graphql($query);

            $propertyTypeSorted = $direction === 'asc' ? $propertyType->sortBy($field) : $propertyType->sortByDesc($field);
            $orderedData     = $propertyTypeSorted->toArray();

            $response->assertStatus(200)
                ->assertJsonCount(10, 'data.property_types.data');
            $this->checkStruct($response, 'property_types', $this->fields);
            $response->assertJson([
                'data' => [
                    'property_types' => [
                        'data' => ksort($orderedData)
                    ]
                ]
            ]);
        }
    }

    public function test_can_get_property_type_sortable_asc(): void
    {
        $this->sortable('asc', $this->fields);
    }

    public function test_can_get_property_type_sortable_desc(): void
    {
        $this->sortable('desc', $this->fields);
    }
}
