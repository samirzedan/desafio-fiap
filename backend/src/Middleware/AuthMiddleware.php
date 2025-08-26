<?php

namespace App\Middleware;

use App\Http\JWT;
use App\Http\Request;
use App\Http\Response;

class AuthMiddleware
{
    public static function handle(Request $request, callable $next)
    {
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            Response::error(message: 'Token not provided', status: 401);
            exit;
        }

        $token = str_replace('Bearer ', '', $headers['Authorization']);
        $payload = JWT::verify($token);

        if (!$payload) {
            Response::error(message: 'Invalid token', status: 401);
            exit;
        }

        $request->user = $payload;

        $next($request);
    }
}
