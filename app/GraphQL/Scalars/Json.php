<?php

declare(strict_types=1);

namespace App\GraphQL\Scalars;

use Exception;
use GraphQL\Error\Error;
use GraphQL\Utils\Utils;
use GraphQL\Language\AST\Node;
use GraphQL\Type\Definition\ScalarType;

class Json extends ScalarType
{
    /**
     * @var string
     */
    public $name = 'Json';

    /**
     * The description that is used for schema introspection.
     *
     * @var string
     */
    public $description = 'Arbitrary data encoded in JavaScript Object Notation. See https://www.json.org/.';

    /**
     * Serializes an internal value to include in a response.
     *
     * @param mixed $value
     *
     * @return string
     */
    public function serialize($value): string
    {
        return json_encode($value);
    }

    /**
     * Parses an externally provided value (query variable) to use as an input.
     *
     * In the case of an invalid value this method must throw an Exception
     *
     * @param mixed $value
     *
     * @return mixed|string
     */
    public function parseValue($value)
    {
        return $this->decodeJSON($value);
    }

    /**
     * Parses an externally provided literal value (hardcoded in GraphQL query) to use as an input.
     *
     * In the case of an invalid node or value this method must throw an Exception
     *
     * @param Node $valueNode
     * @param mixed[]|null $variables
     *
     * @throws Exception
     *
     * @return mixed
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        if (!property_exists($valueNode, 'value')) {
            throw new Error(
                'Can only parse literals that contain a value, got '.Utils::printSafeJson($valueNode)
            );
        }
        return $this->decodeJSON($valueNode->value);
    }

    /**
     * Try to decode a user-given value into JSON.
     * @param $value
     *
     * @return string
     */
    protected function decodeJSON($value) :string
    {
        return json_decode($value, false, 512, JSON_THROW_ON_ERROR);
    }


    /**
     * @return Json
     */
    public function toType() : Json
    {
        return new static();
    }
}
