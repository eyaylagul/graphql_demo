<?php
namespace App\GraphQL\Mutations\City;

use App\Rules\Lat;
use App\Rules\Lng;
use App\Models\City;
use App\Traits\GraphQLAuth;
use Illuminate\Support\Arr;
use GraphQL\Type\Definition\Type;
use Rebing\GraphQL\Support\Mutation;
use Rebing\GraphQL\Support\Facades\GraphQL;
use GraphQL\Type\Definition\Type as GraphqlType;

class Upsert extends Mutation
{
    use GraphQLAuth;

    protected $permissionReqAll = true;
    protected $permission = 'city.create|city.update';

    public function type(): GraphqlType
    {
        return GraphQL::type('Cities');
    }

    public function rules(array $args = []) :array
    {
        return [
            'id'       => 'exists:city,id',
            'name'     => 'required|string|max:100',
            'lat'      => ['required', new Lat],
            'lng'      => ['required', new Lng],
            'state_id' => 'required|exists:state,id'
        ];
    }

    public function args() :array
    {
        return [
            'id'       => [
                'name' => 'id',
                'type' => Type::id(),
            ],
            'name'     => [
                'name' => 'name',
                'type' => Type::nonNull(Type::string()),
            ],
            'lat'      => [
                'name' => 'lat',
                'type' => Type::nonNull(Type::float()),
            ],
            'lng'      => [
                'name' => 'lng',
                'type' => Type::nonNull(Type::float()),
            ],
            'state_id' => [
                'name' => 'state_id',
                'type' => Type::nonNull(Type::id())
            ],
        ];
    }

    public function resolve($root, $args) :City
    {
        $city = City::updateOrCreate([
            'id' => Arr::get($args, 'id')
        ], [
            'name'     => $args['name'],
            'lat'      => $args['lat'],
            'lng'      => $args['lng'],
            'state_id' => $args['state_id']
        ]);

        return $city;
    }
}
