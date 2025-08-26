<?php

namespace App\Http;

class Route
{
    private static array $routes = [];

    public static function get(string $path, string $action, array $middlewares = []): void
    {
        self::addRoute('GET', $path, $action, $middlewares);
    }

    public static function post(string $path, string $action, array $middlewares = []): void
    {
        self::addRoute('POST', $path, $action, $middlewares);
    }

    public static function put(string $path, string $action, array $middlewares = []): void
    {
        self::addRoute('PUT', $path, $action, $middlewares);
    }

    public static function patch(string $path, string $action, array $middlewares = []): void
    {
        self::addRoute('PATCH', $path, $action, $middlewares);
    }

    public static function delete(string $path, string $action, array $middlewares = []): void
    {
        self::addRoute('DELETE', $path, $action, $middlewares);
    }

    private static function addRoute(string $method, string $path, string $action, array $middlewares): void
    {
        self::$routes[] = [
            'path' => $path,
            'action' => $action,
            'method' => $method,
            'middlewares' => $middlewares,
        ];
    }

    public static function routes(): array
    {
        return self::$routes;
    }
}
