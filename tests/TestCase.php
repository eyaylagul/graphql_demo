<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use MarvinRabe\LaravelGraphQLTest\TestGraphQL;
use \Illuminate\Foundation\Testing\TestResponse;

abstract class TestCase extends BaseTestCase
{
    use TestGraphQL;
    use CreatesApplication;
    public $graphQLEndpoint = 'api';

    public function graphql($query) :TestResponse
    {
        return $this->post($this->graphQLEndpoint, [
            'query' => $query
        ]);
    }

    protected function checkStruct(TestResponse $response, string $object, array $fields) :void
    {
        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    $object => [
                        'data' => [
                            $fields
                        ]
                    ]
                ]
            ]);
    }
}
