<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    public function successResponse(string $message, $data = null, int $httpCode = 200): JsonResponse
    {
        return response()->json([
            'message' => $message,
            'data' => $data
        ], $httpCode);
    }

    public function errorResponse(string $message, string $type = 'error', int $httpCode = 500): JsonResponse
    {
        return response()->json([
            'type' => $type,
            'message' => $message,
        ], $httpCode);
    }

    public function needAuthResponse(bool $canRefresh): JsonResponse
    {
        return response()->json([
            'message' => 'Unauthenticated',
            'can_refresh' => $canRefresh
        ], 401);
    }
}
