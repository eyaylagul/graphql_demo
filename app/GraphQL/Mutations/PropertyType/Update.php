<?php

namespace App\GraphQL\Mutations\PropertyType;

use App\Models\PropertyType;
use Rebing\GraphQL\Support\Facades\GraphQL;
use Rebing\GraphQL\Support\Mutation;
use GraphQL\Type\Definition\Type;
use App\Traits\GraphQLAuth;

class Update extends Mutation
{
    use GraphQLAuth;

    protected $permission = 'property_type.update';

    public function type()
    {
        return GraphQL::type('PropertyTypes');
    }

    public function rules(array $args = []): array
    {
        return [
            'id'          => 'required|exists:property_type,id',
            'name'        => 'required|string|max:100',
            'description' => 'required|string|max:255'
        ];
    }

    public function args(): array
    {
        return [
            'id'       => [
                'name' => 'id',
                'type' => Type::nonNull(Type::id())
            ],
            'name'     => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string())
            ],
            'description'     => [
                'name' => 'description',
                'type' => Type::nonNull(Type::string())
            ]
        ];
    }

    public function resolve($root, $args): PropertyType
    {
        $propertyType = PropertyType::find($args['id']);
        $propertyType->name = $args['name'];
        $propertyType->description = $args['description'];
        $propertyType->save();

        return $propertyType;
    }
}