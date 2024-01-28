<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    protected function unauthenticated($request, array $guards)
    {
        if ($request->is('api/*')) {
            abort(response()->json(
            [
                'code' => 401,
                'success' => false,
                'time' => Carbon::now(),
                'message' => 'You are not allowed to make this action!',
                'data' => null
            ], 401));
        }

        Parent::unauthenticated($request, $guards);
    }

    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        return $request->expectsJson() ? null : route('login');
    }
}
