<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

trait ApiResponseTrait
{
    /**
     * Success response with data
     * @param $data
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse($data, string $message = 'Success', int $code = 200): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'message' => $message,
            'data' => $data,
        ], $code);
    }

    /**
     * Error response
     * @param string $message
     * @param int $code
     * @return JsonResponse
     */
    public function errorResponse(string $message = 'An error occurred', int $code = 500): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], $code);
    }

    /**
     * Validation error response
     * @param ValidationException $exception
     * @return JsonResponse
     */
    public function validationErrorResponse(ValidationException $exception): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => 'Validation Error',
            'errors' => $exception->errors(),
        ], 422);
    }

    /**
     * Not Found response
     * @param string $message
     * @return JsonResponse
     */
    public function notFoundResponse(string $message = 'Resource not found'): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 404);
    }

    /**
     * Forbidden access response
     * @param string $message
     * @return JsonResponse
     */
    public function forbiddenResponse(string $message = 'Forbidden access'): JsonResponse
    {
        return response()->json([
            'status' => 'error',
            'message' => $message,
        ], 403);
    }
}
