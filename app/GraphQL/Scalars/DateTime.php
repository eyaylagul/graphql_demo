<?php

namespace App\GraphQL\Scalars;

use Carbon\Carbon;
use GraphQL\Error\Error;
use GraphQL\Utils\Utils;
use GraphQL\Language\AST\Node;
use GraphQL\Error\InvariantViolation;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Language\AST\StringValueNode;

class DateTime extends ScalarType
{
    /**
     * @var string
     */
    public $name = 'DateTime';

    /**
     * @var string
     */
    public $description = 'DateTime scalar type in format';

    /**
     * Serialize an internal value, ensuring it is a valid datetime string.
     *
     * @param mixed $value
     *
     * @return string
     * @throws Error
     */
    public function serialize($value): string
    {
        if ($value instanceof Carbon) {
            return $value->toAtomString();
        }
        return $this->tryParsingDateTime($value, InvariantViolation::class)
            ->toAtomString();
    }

    /**
     * Parse a externally provided variable value into a Carbon instance.
     * @param mixed $value
     *
     * @return Carbon
     * @throws Error
     */
    public function parseValue($value): Carbon
    {
        return $this->tryParsingDateTime($value, Error::class);
    }

    /**
     * Parse a literal provided as part of a GraphQL query string into a Carbon instance.
     *
     * @param Node         $valueNode
     * @param mixed[]|null $variables
     *
     * @throws Error
     *
     * @return Carbon
     */
    public function parseLiteral($valueNode, array $variables = null): Carbon
    {
        if (! $valueNode instanceof StringValueNode) {
            throw new Error('Query error: Can only parse strings got: '.$valueNode->kind, [$valueNode]);
        }
        return $this->tryParsingDateTime($valueNode->value, Error::class);
    }

    /**
     * Try to parse the given value into a Carbon instance, throw if it does not work.
     *
     * @param mixed  $value
     * @param string $exceptionClass
     *
     * @throws InvariantViolation|Error
     *
     * @return Carbon
     */
    private function tryParsingDateTime($value, string $exceptionClass): Carbon
    {
        try {
            return Carbon::createFromFormat(Carbon::DEFAULT_TO_STRING_FORMAT, $value);
        } catch (\Exception $e) {
            throw new $exceptionClass(
                Utils::printSafeJson($e->getMessage())
            );
        }
    }



    /**
     * @return DateTime
     */
    public function toType() : DateTime
    {
        return new static();
    }
}
