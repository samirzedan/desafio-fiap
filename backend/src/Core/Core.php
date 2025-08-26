<?php

namespace App\Core;

use App\Http\Request;
use App\Http\Response;

class Core
{
    public static function dispatch(array $routes)
    {
        $url = '/';
        isset($_GET['url']) && $url .= $_GET['url'];
        $url !== '/' && $url = rtrim($url, '/');

        $prefixController = 'App\\Controllers\\';

        $routeFound = false;
        $methodNotAllowed = false;

        foreach ($routes as $route) {
            $pattern = '#^' . preg_replace('/{id}/', '([\w-]+)', $route['path']) . '$#';

            if (preg_match($pattern, $url, $matches)) {
                $routeFound = true;

                if ($route['method'] !== Request::method()) {
                    $methodNotAllowed = true;
                    continue;
                }

                array_shift($matches);
                [$controller, $action] = explode('@', $route['action']);
                $controller = $prefixController . $controller;
                $extendController = new $controller();

                $req = new Request();
                $res = new Response();

                $next = function ($request) use ($extendController, $action, $matches, $res) {
                    $extendController->$action($request, $res, $matches);
                };

                foreach ($route['middlewares'] as $middleware) {
                    if (class_exists($middleware) && method_exists($middleware, 'handle')) {
                        $currentNext = $next;
                        $next = fn ($request) => $middleware::handle($request, $currentNext);
                    }
                }

                $next($req);
                return;
            }
        }

        if ($methodNotAllowed) {
            return Response::error(message: "Method not allowed", status: 405);
        }

        if (!$routeFound) {
            $controller = $prefixController . 'NotFoundController';
            $extendController = new $controller();
            $extendController->index(new Request(), new Response());
        }
    }
}
