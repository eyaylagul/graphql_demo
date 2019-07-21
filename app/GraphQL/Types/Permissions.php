<?php
namespace App\GraphQL\Types;

use App\Models\Permission;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Type as GraphQLType;

class Permissions extends GraphQLType
{
    protected $attributes = [
        'name' => 'Permissions',
        'model' => Permission::class,
    ];

    public function fields() :array
    {
        return [
            'id' => [
                'type' => Type::id(),
            ],
            'name' => [
                'type' => Type::string(),
                'description' => 'System name is using by system'
            ],
            'display_name' => [
                'type' => Type::string()
            ],
            'description' => [
                'type' => Type::string()
            ],
            'created_at' => [
                'type' => GraphQL::type('DateTime')
            ],
            'updated_at' => [
                'type' => GraphQL::type('DateTime')
            ]
        ];
    }
}
