<?php

namespace App\Traits;

use JWTAuth;
use Exception;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * App\Traits\GraphQLAuth
 * Current class using in graphql query or mutation to check AUTH and permissions
 *
 * @property boolean $permissionReqAll - Passing true instructs the method to require all permissions. By default false
 */
trait GraphQLAuth
{
    /**
     * Check authorization user
     *
     * @param array $args
     *
     * @return bool
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     */
    public function authorize(array $args): bool
    {
        // check bearer toke from header
        if (!JWTAuth::parseToken()->authenticate()) {
            return false;
        }
        // each class which use this trait should define property permission
        if (!isset($this->permission)) {
            throw new Exception('Permission for this query not found');
        }
        if (!\Laratrust::can(
            $this->permission,
            null,
            isset($this->permissionReqAll) && $this->permissionReqAll === true ?: false
        )) {
            throw new AccessDeniedHttpException('FORBIDDEN');
        };

        return true;
    }
}
