<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\State;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StateTest extends TestCase
{
    use RefreshDatabase;

    public $graphQLEndpoint = 'api/public';
    public $fields = ['id', 'code', 'name', 'country' => ['id', 'code', 'name']];

    public function test_can_get_state(): void
    {
        /** @var Collection $state */
        $state    = factory(State::class)->create();
        $response = $this->query('states', ['data' => $this->fields]);

        $response->assertStatus(200)
            ->assertJsonCount(1, 'data.states.data');
        $this->checkStruct($response, 'states', $this->fields);
        $response->assertJson([
            'data' => [
                'states' => [
                    'data' => [
                        $state->makeHidden('country_id')->toArray()
                    ]
                ]
            ]
        ]);
    }

    public function test_can_get_state_filterable(): void
    {
        /** @var Collection $state */
        $state = factory(State::class, 10)->create();
        foreach (Arr::except($this->fields, ['country']) as $field) {
            $response    = $this->query(
                'states',
                ['filter' => [$field => $state[5]->$field]],
                ['data' => $this->fields]
            );
            $orderedData = $state[5]->makeHidden('country_id')->toArray();

            $response->assertStatus(200)
                ->assertJsonCount(1, 'data.states.data');
            $this->checkStruct($response, 'states', $this->fields);
            $response->assertJson([
                'data' => [
                    'states' => [
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
        /** @var Collection $state */
        $state = factory(State::class, 10)->create();

        foreach ($fields as $field) {
            $query    = "{
                    states(sort: {sort_by: \"$field\", type: {$direction}}){
                        data {
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
                }";
            $response = $this->graphql($query);

            $sorted = $direction === 'asc' ? $state->sortBy($field) : $state->sortByDesc($field);
            $orderedData = $sorted->makeHidden('country_id')->toArray();

            $response->assertStatus(200)
                ->assertJsonCount(10, 'data.states.data');
            $this->checkStruct($response, 'states', $this->fields);
            $response->assertJson([
                'data' => [
                    'states' => [
                        'data' => ksort($orderedData)
                    ]
                ]
            ]);
        }
    }

    public function test_can_get_state_sortable_asc(): void
    {
        $this->sortable('asc', Arr::except($this->fields, ['country']));
    }

    public function test_can_get_state_sortable_desc(): void
    {
        $this->sortable('desc', Arr::except($this->fields, ['country']));
    }
}
