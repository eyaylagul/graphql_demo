<?php
declare(strict_types=1);

return [
    'route_name' => 'graphql-playground',
    'route' => [
        // 'prefix' => '',
        // 'middleware' => ['web']
        'domain' => env('GRAPHQL_PLAYGROUND_DOMAIN', null),
    ],
    'endpoint' => 'graphql',
    'enabled' => env('GRAPHQL_PLAYGROUND_ENABLED', true),
];


//return [
//    // Route for the frontend
//    'route'      => 'graphql-playground',
//
//    // Which middleware to apply, if any
////    'middleware' => [
////        // 'web',
////    ],
//
//    // Route for the GraphQL endpoint
//    'endpoint'   => 'api',
//
//    // Control if the playground is accessible at all
//    // This allows you to disable it completely in production
//    'enabled'    => env('GRAPHQL_PLAYGROUND_ENABLED', true),
//];
