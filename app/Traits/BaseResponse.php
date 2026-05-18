<?php

namespace App\Traits;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

trait BaseResponse
{

    /**
     * Building success response
     * @param $data
     * @param int $code
     * @return JsonResponse
     */
    public function successResponse(string $message = 'success', $data = null, int $statusCode = Response::HTTP_OK): JsonResponse
    {
        return response()->json([
            'status' => true,
            'message' => __('messages.' . $message),
            'data' => $data,
        ], $statusCode);
    }
    /**
     * Building success response
     * @param $data
     * @param int $code
     * @return JsonResponse
     */

    public function errorResponse(string $message = 'An error occurred.', $statusCode = Response::HTTP_BAD_REQUEST, $data = null): JsonResponse
    {
        Log::error('Error response generated', [
            'message' => $message,
            'status_code' => $statusCode,
            'data' => $data,
        ]);

        return response()->json([
            'status' => false,
            'message' => __('messages.' . $message),
            'data' => $data,
        ], $statusCode);
    }

    public function exceptionResponse(Exception $e, string $defaultMessage = 'An error occurred.'): JsonResponse
    {
        // Prefer explicit HTTP status from Laravel/Symfony HTTP exceptions and ValidationException
        // if ($e instanceof ValidationException && method_exists($e, 'status')) {
        //     $statusCode = $e->status();
        // } else
        if (method_exists($e, 'getStatusCode')) {
            $statusCode = $e->getStatusCode();
        } else {
            $statusCode = $e->getCode();
        }

        $statusCode = is_numeric($statusCode) ? (int) $statusCode : Response::HTTP_INTERNAL_SERVER_ERROR;
        if ($statusCode < 100 || $statusCode >= 600) {
            $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR;
        }

        // For ValidationException, use Laravel's built-in messages
        $message = $e instanceof ValidationException
            ? 'Validation errors'
            : (config('app.debug') ? __($e->getMessage()) : $defaultMessage);

        $errors = $e instanceof ValidationException
            ? $e->errors()
            : null;

        Log::error('Exception occurred', [
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
        ]);

        return response()->json([
            'status'  => false,
            'message' => $message,
            'errors'  => $errors,
            'data'    => null,
        ], $statusCode);
    }
}
