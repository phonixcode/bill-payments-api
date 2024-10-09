<?php

namespace App\Exceptions;

use Throwable;
use App\Traits\ApiResponseTrait;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    use ApiResponseTrait; 
    
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

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof ModelNotFoundException) {
            return $this->notFoundResponse();
        }

        // Handle validation exceptions
        if ($exception instanceof ValidationException) {
            return $this->validationErrorResponse($exception);
        }

        // Handle not found exceptions
        if ($exception instanceof NotFoundHttpException) {
            return $this->notFoundResponse();
        }

        // Handle other exceptions (general error)
        return $this->errorResponse('An unexpected error occurred.', 500);
    }
}
