<?php

namespace App\Exceptions;

use Carbon\Carbon;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        // dd($e instanceof AuthorizationException);
        if ($request->is('api/*') && $e instanceof AuthorizationException) {

            return response()->json([
                'code' => 403,
                'success' => false,
                'time' => Carbon::now(),
                'message' => 'You are not allowed to make this action!',
                'data' => null
            ], 403);
        }
        
        if ($e instanceof ModelNotFoundException) {
            return response()->json([
                'code' => 404,
                'success' => false,
                'time' => Carbon::now(),
                'message' => 'Resource not found!',
                'data' => null
            ], 404);
        }

        return parent::render($request, $e);
    }
}
