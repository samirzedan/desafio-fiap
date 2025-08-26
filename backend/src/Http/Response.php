<?php

namespace App\Http;

use Exception;

class Response
{
    public static function success(?string $message = null, mixed $data = null, int $status = 200, mixed $params = []): void
    {
        self::json([
            'success' => true,
            'message' => $message,
            'data' => $data,
            ...$params
        ], $status);
    }

    public static function error(?string $message = null, ?Exception $exception = null, int $status = 500, mixed $params = []): void
    {
        self::json([
            'success' => false,
            'message' => $message ?? 'An error occurred',
            'error' => $exception?->getMessage() ?? [],
            ...$params
        ], $status);
    }

    private static function json(array $data, int $status): void
    {
        http_response_code($status);
        header("Content-Type: application/json; charset=utf-8");

        echo json_encode(
            $data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );
    }
}
