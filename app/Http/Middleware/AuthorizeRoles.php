<?php

namespace App\Http\Middleware;

use Closure;

class AuthorizeRoles
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roles)
    {
        if (! $request->user()->hasRoles($roles)) {
            abort(401, 'This action is unauthorized.');
        }

        return $next($request);
    }
}
