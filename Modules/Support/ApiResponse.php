<?php

namespace Modules\Support;

use Arr;
use Illuminate\Http\JsonResponse;

class ApiResponse
{
    /**
     * handler error response
     *
     * @param mixed $errors
     * @param string|null $message
     * @param int $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function errors(mixed $errors, string|null $message = null, int $code = 400, mixed $data = null): JsonResponse
    {
        return self::response($data, $message, $errors, $code);
    }

    /**
     * Handler success response
     *
     * @param mixed  $body
     * @param string|null $message
     * @param int         $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public static function success(mixed $body = null, string|null $message = null, int $code = 200): JsonResponse
    {
        return self::response($body, $message, null, $code);
    }

    /**
     * Handler api response
     *
     * @param mixed   $body
     * @param string|null  $message
     * @param mixed        $errors
     * @param int          $code
     *
     * @return \Illuminate\Http\JsonResponse
     */
    private static function response(mixed $body, string|null $message, mixed $errors, int $code): JsonResponse
    {
        return response()->json(array_filter([
            "body" => $body,
            "message" => is_null($message) && !is_null($errors) && count($errors) > 0
                ? (is_array($errors) ? Arr::first($errors) : $errors)
                : $message,
            "errors" => $errors,
        ], fn ($value) => !is_null($value)), $code);
    }
}
