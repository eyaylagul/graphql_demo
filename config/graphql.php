<?php

return [

    // The prefix for routes
    'prefix'                 => 'api',

    // The routes to make GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Route
    //
    // Example:
    //
    // Same route for both query and mutation
    //
    // 'routes' => 'path/to/query/{graphql_schema?}',
    //
    // or define each route
    //
    // 'routes' => [
    //     'query' => 'query/{graphql_schema?}',
    //     'mutation' => 'mutation/{graphql_schema?}',
    // ]
    //
    'routes'                 => '{graphql_schema?}',

    // The controller to use in GraphQL request. Either a string that will apply
    // to both query and mutation or an array containing the key 'query' and/or
    // 'mutation' with the according Controller and method
    //
    // Example:
    //
    // 'controllers' => [
    //     'query' => '\Rebing\GraphQL\GraphQLController@query',
    //     'mutation' => '\Rebing\GraphQL\GraphQLController@mutation'
    // ]
    //
    'controllers'            => Rebing\GraphQL\GraphQLController::class . '@query',

    // Any middleware for the graphql route group
    'middleware'             => ['cors'],

    // Additional route group attributes
    //
    // Example:
    //
    // 'route_group_attributes' => ['guard' => 'api']
    //
    'route_group_attributes' => [],

    // The name of the default schema used when no argument is provided
    // to GraphQL::schema() or when the route is used without the graphql_schema
    // parameter.
    'default_schema'         => 'dashboard',

    // The schemas for query and/or mutation. It expects an array of schemas to provide
    // both the 'query' fields and the 'mutation' fields.
    //
    // You can also provide a middleware that will only apply to the given schema
    //
    'schemas'                => [
        'dashboard' => [
            'query'      => [
                'users'       => App\GraphQL\Queries\UsersQuery::class,
                'permissions' => App\GraphQL\Queries\PermissionsQuery::class,
                'roles'       => App\GraphQL\Queries\RolesQuery::class,
            ],
            'mutation'   => [
                'logOut'      => App\GraphQL\Mutations\LogOutMutation::class,
                'updateToken' => App\GraphQL\Mutations\UpdateTokenMutation::class,

                'userCreate'         => App\GraphQL\Mutations\User\Create::class,
                'userUpdate'         => App\GraphQL\Mutations\User\Update::class,
                'userUpdatePassword' => App\GraphQL\Mutations\User\UpdatePassword::class,

                'stateUpsert' => App\GraphQL\Mutations\State\Upsert::class,
                'stateDelete' => App\GraphQL\Mutations\State\Delete::class,

                'cityUpsert' => App\GraphQL\Mutations\City\Upsert::class,
                'cityDelete' => App\GraphQL\Mutations\City\Delete::class,

                'roleUpsert'         => App\GraphQL\Mutations\Role\Upsert::class,
                'roleDelete'         => App\GraphQL\Mutations\Role\Delete::class,

                'propertyTypeUpdate' => App\GraphQL\Mutations\PropertyType\Update::class,
            ],
            'middleware' => [], // todo add middleware AUTH JWT
            'method'     => ['get', 'post'],
        ],
        'public'    => [
            'query'      => [
                'countries'      => App\GraphQL\Queries\CountriesQuery::class,
                'states'         => App\GraphQL\Queries\StatesQuery::class,
                'cities'         => App\GraphQL\Queries\CitiesQuery::class,
                'property_types' => App\GraphQL\Queries\PropertyTypesQuery::class,
            ],
            'mutation'   => [
                'signUp' => App\GraphQL\Mutations\SignUpMutation::class,
                'logIn'  => App\GraphQL\Mutations\LogInMutation::class,
            ],
            'middleware' => [],
            'method'     => ['get', 'post'],
        ],
    ],

    // The types available in the application. You can then access it from the
    // facade like this: GraphQL::type('user')
    //
    // Example:
    //
    // 'types' => [
    //     'user' => 'App\GraphQL\Type\UserType'
    // ]
    //
    'types'                  => [
        // scalar types
        'DateTime'      => App\GraphQL\Scalars\DateTime::class,
        'Date'          => App\GraphQL\Scalars\Date::class,
        // enum
        'SortDirection' => App\GraphQL\Enum\SortDirection::class,
        'UserStatus'    => App\GraphQL\Enum\UserStatus::class,
        // input types
        'Sortable'      => App\GraphQL\Scalars\Sortable::class,
        'Pagination'    => App\GraphQL\Scalars\Pagination::class,
        'DateTimeRange' => App\GraphQL\Scalars\DateTimeRange::class,
        'IntRange'      => App\GraphQL\Scalars\IntRange::class,

        'Users'              => App\GraphQL\Types\Users::class,
        'Permissions'        => App\GraphQL\Types\Permissions::class,
        'Roles'              => App\GraphQL\Types\Roles::class,
        'Countries'          => App\GraphQL\Types\Countries::class,
        'States'             => App\GraphQL\Types\States::class,
        'Cities'             => App\GraphQL\Types\Cities::class,
        'PropertyTypes'      => App\GraphQL\Types\PropertyTypes::class,
        'Auth'               => App\GraphQL\Types\Auth::class,

        // Input filters
        'UserFilter'         => App\GraphQL\Types\Filters\UserFilter::class,
        'PermissionFilter'   => App\GraphQL\Types\Filters\PermissionFilter::class,
        'RoleFilter'         => App\GraphQL\Types\Filters\RoleFilter::class,
        'CountryFilter'      => App\GraphQL\Types\Filters\CountryFilter::class,
        'StateFilter'        => App\GraphQL\Types\Filters\StateFilter::class,
        'CityFilter'         => App\GraphQL\Types\Filters\CityFilter::class,
        'PropertyTypeFilter' => App\GraphQL\Types\Filters\PropertyTypeFilter::class,
    ],

    // This callable will be passed the Error object for each errors GraphQL catch.
    // The method should return an array representing the error.
    // Typically:
    // [
    //     'message' => '',
    //     'locations' => []
    // ]
    'error_formatter'        => [App\GraphQL\Exceptions\GraphQLExceptions::class, 'formatError'],
    'errors_handler'         => [App\GraphQL\Exceptions\GraphQLExceptions::class, 'handleErrors'],

    // You can set the key, which will be used to retrieve the dynamic variables
    'params_key'             => 'variables',

    /*
     * Options to limit the query complexity and depth. See the doc
     * @ https://github.com/webonyx/graphql-php#security
     * for details. Disabled by default.
     */
    'security'               => [
        'query_max_complexity'  => null,
        'query_max_depth'       => null,
        'disable_introspection' => false,
    ],

    /*
     * You can define your own pagination type.
     * Reference \Rebing\GraphQL\Support\PaginationType::class
     */
//    'pagination_type'        => Rebing\GraphQL\Support\PaginationType::class,
    'pagination_type'        => App\GraphQL\Scalars\PaginationType::class,

    /*
     * Config for GraphiQL (see (https://github.com/graphql/graphiql).
     */
    'graphiql'               => [
        'prefix'     => '/graphiql/{graphql_schema?}',
        'controller' => Rebing\GraphQL\GraphQLController::class . '@graphiql',
        'middleware' => [],
        'view'       => 'graphql::graphiql',
        'display'    => env('ENABLE_GRAPHIQL', false),
    ],

    /*
     * Overrides the default field resolver
     * See http://webonyx.github.io/graphql-php/data-fetching/#default-field-resolver
     *
     * Example:
     *
     * ```php
     * 'defaultFieldResolver' => function ($root, $args, $context, $info) {
     * },
     * ```
     * or
     * ```php
     * 'defaultFieldResolver' => [SomeKlass::class, 'someMethod'],
     * ```
     */
    'defaultFieldResolver'   => null,

    /*
     * Any headers that will be added to the response returned by the default controller
     */
    'headers'                => [],

    /*
     * Any JSON encoding options when returning a response from the default controller
     * See http://php.net/manual/function.json-encode.php for the full list of options
     */
    'json_encoding_options'  => 0,
];
