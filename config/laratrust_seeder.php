<?php

return [
    'role_structure'  => [
        'administrator' => [
            'user'          => 'c,r,u,up',
            'post'          => 'c,r,u,d',
            'category'      => 'c,r,u,d',
            'role'          => 'c,r,u,d',
            'permission'    => 'r',
            'city'          => 'c,r,u,d',
            'state'         => 'c,r,u,d',
            'country'       => 'r',
            'property_type' => 'r,u',
            'property'      => 'c,r,u,d',
        ],
        'manager'       => [
            'user'          => 'r,u',
            'post'          => 'r,u',
            'category'      => 'r,u',
            'city'          => 'r',
            'state'         => 'r',
            'country'       => 'r',
            'property_type' => 'r,u',
            'property'      => 'c,r,u,d',
        ],
        'editor'        => [
            'user'          => 'r,u',
            'post'          => 'r,u',
            'category'      => 'r,u',
            'property_type' => 'r',
            'property'      => 'r',
        ],
    ],
//    'permission_structure' => [
//        'admin' => [
//            'user' => 'c,r,u,d',
//        ],
//    ],
    'permissions_map' => [
        'c'  => 'create',
        'r'  => 'view',
        'u'  => 'update',
        'd'  => 'delete',
        'up' => 'update.password'
    ]
];
