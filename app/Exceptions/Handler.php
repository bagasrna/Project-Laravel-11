<?php

namespace App\Exceptions;

use App\Traits\ApiResponse;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ApiResponse;
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
        $this->renderable(function (Throwable $e) {
            if ($e instanceof NotFoundHttpException && str_contains($e->getMessage(), 'model')) {
                $firstIndex = strpos($e->getMessage(), 'Models\\') + 7;
                $lastIndex = strpos($e->getMessage(), ']');
                $model = substr($e->getMessage(), $firstIndex, $lastIndex - $firstIndex);
                Log::error($e->getMessage());

                return $this->errorResponse("Data $model not found", 'NOT_FOUND', 409);
            } else if ($e instanceof ModelNotFoundException) {
                Log::error($e->getMessage());
                return $this->errorResponse('Data not found', 'NOT_FOUND', 404);
            } else if ($e instanceof NotFoundHttpException) {
                Log::error($e->getMessage());
                return $this->errorResponse('Url not found', 'NOT_FOUND', 404);
            } else if ($e instanceof MethodNotAllowedHttpException) {
                Log::error($e->getMessage());
                return $this->errorResponse('Method not allowed', 'INVALID_ACTION', 405);
            } else if ($e instanceof UnauthorizedException) {
                Log::error($e->getMessage());
                return $this->errorResponse('You don\'t have access', 'NOT_FOUND', 401);
            } else {
                Log::error($e->getMessage());
                return $this->errorResponse('Internal server error', 'SERVER_ERROR', 500);
            }
        });
    }
}
