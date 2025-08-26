<?php

namespace App\Http;

class Request
{
    public array $user = [];

    public static function method()
    {
        return $_SERVER["REQUEST_METHOD"];
    }

    public static function body(): array
    {
        $json = json_decode(file_get_contents('php://input'), true) ?? [];

        $data = match(self::method()) {
            'GET' => $_GET,
            'POST', 'PUT', 'PATCH', 'DELETE' => $json,
            default => []
        };

        if (!is_array($data)) {
            $data = [];
        }

        return $data;
    }

    public static function authorization(): ?string
    {
        $headers = getallheaders();
        return $headers['Authorization'] ?? null;
    }
}
