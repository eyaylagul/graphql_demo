<?php

namespace App\GraphQL\Exceptions;

use Exception;
use GraphQL\Error\Debug;
use GraphQL\Error\FormattedError;
use Rebing\GraphQL\Error\ValidationError;
use Rebing\GraphQL\Error\AuthorizationError;
use Illuminate\Contracts\Debug\ExceptionHandler;
use \Tymon\JWTAuth\Exceptions\JWTException;
use \Tymon\JWTAuth\Exceptions\TokenInvalidException;
use \Tymon\JWTAuth\Exceptions\TokenExpiredException;
use \Tymon\JWTAuth\Exceptions\TokenBlacklistedException;

class GraphQLExceptions
{
    /**
     * @param Exception $e
     *
     * @return mixed
     */
    public static function formatError(Exception $e)
    {
        $debug = config('app.debug') ? (Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE) : 0;
        $formatter = FormattedError::prepareFormatter(null, $debug);
        $error = $formatter($e);
        $error['message'] = $e->getMessage();

        $previous = $e->getPrevious();
        if ($previous && $previous instanceof ValidationError) {
            $error['validation'] = $previous->getValidatorMessages();
        }
        if ($previous && $previous instanceof TokenExpiredException) {
            $error['message'] = 'TOKEN_EXPIRED';
        }
        if ($previous && $previous instanceof TokenInvalidException) {
            $error['message'] = 'TOKEN_INVALID';
        }
        if ($previous && $previous instanceof JWTException) {
            $error['message'] = 'TOKEN_INVALID';
        }
        if ($previous && $previous instanceof TokenBlacklistedException) {
            $error['message'] = 'TOKEN_BLACKLISTED';
        }

        return $error;
    }

    /**
     * Function to handle errors and for debugging
     *
     * @param array    $errors
     * @param callable $formatter
     *
     * @return array
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public static function handleErrors(array $errors, callable $formatter) :array
    {
        $handler = app()->make(ExceptionHandler::class);
        foreach ($errors as $error) {
            // Try to unwrap exception
            $error = $error->getPrevious() ?: $error;
            // Don't report certain GraphQL errors
            if ($error instanceof ValidationError
                || $error instanceof AuthorizationError
                || ! ($error instanceof Exception)) {
                continue;
            }
            $handler->report($error);
        }

        return array_map($formatter, $errors);
    }
}
