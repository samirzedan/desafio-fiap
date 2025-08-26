<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Http\Request;
use App\Http\Response;
use App\Services\UserService;
use App\Utils\Validator;
use Exception;

class UserController
{
    public function store(Request $request, Response $response)
    {
        try {
            $fields = Validator::validate($request::body(), [
                'nome' => ['required', 'string', 'min:3', 'max:255'],
                'email' => ['required', 'email', 'max:255'],
                'senha' => ['required', 'string', 'strong_password', 'min:8', 'max:255']
            ]);

            $userService = UserService::create($fields);

            if (isset($userService['error'])) {
                return $response::error(message: $userService['error'], status: 400);
            }

            return $response::success(message: $userService, status: 201);
        } catch (ValidationException $e) {
            return $response::error(exception: $e, status: 422, params: ['errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function login(Request $request, Response $response)
    {
        try {
            $fields = Validator::validate($request::body(), [
                'email' => ['required', 'email'],
                'senha' => ['required', 'string'],
            ]);

            $userService = UserService::auth($fields);

            if (isset($userService['error'])) {
                return $response::error(message: $userService['error'], status: 400);
            }

            return $response::success(data: $userService, status: 200);
        } catch (ValidationException $e) {
            return $response::error(exception: $e, status: 422, params: ['errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function fetch(Request $request, Response $response)
    {
        $user = $request->user;
        $userService = UserService::fetch($user['id']);

        return $response::success(data: $userService, status: 200);
    }
}
