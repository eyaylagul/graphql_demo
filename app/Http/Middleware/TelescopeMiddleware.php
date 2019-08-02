<?php

namespace App\Http\Middleware;

use Closure;

class TelescopeMiddleware
{
    /**
     * @param         $request
     * @param Closure $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $emails = explode(',', config('app.email_admin'));
        if (auth()->check() && in_array(auth()->user()->email, $emails, true)) {
            return $next($request);
        }
        abort(403);
    }
}
