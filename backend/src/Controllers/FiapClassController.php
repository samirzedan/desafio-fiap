<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Http\Request;
use App\Http\Response;
use App\Services\FiapClassService;
use App\Utils\Validator;
use Exception;

class FiapClassController
{
    public function index(Request $request, Response $response, array $id)
    {
        try {
            $fields = Validator::validate($request::body(), [
                'page' => ['nullable', 'numeric'],
                'query' => ['nullable', 'string'],
            ]);

            $page = $fields['page'] ?? 1;
            $query = $fields['query'] ?? null;

            $classService = FiapClassService::index($page, $query);

            if (isset($classService['error'])) {
                return $response::error(message: $classService['error'], status: 400);
            }

            return $response::success(data: $classService, status: 200);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function fetch(Request $request, Response $response, array $id)
    {
        try {
            $classService = FiapClassService::fetch($id[0]);

            if (isset($classService['error'])) {
                return $response::error(message: $classService['error'], status: 400);
            }

            return $response::success(data: $classService, status: 200);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function store(Request $request, Response $response)
    {
        try {
            $fields = Validator::validate($request::body(), [
                'nome' => ['required', 'string', 'min:3', 'max:255'],
                'descricao' => ['required', 'string', 'min:3', 'max:255'],
            ]);

            $classService = FiapClassService::create($fields);

            if (isset($classService['error'])) {
                return $response::error(message: $classService['error'], status: 400);
            }

            return $response::success(message: $classService, status: 201);
        } catch (ValidationException $e) {
            return $response::error(exception: $e, status: 422, params: ['errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function update(Request $request, Response $response, array $id)
    {
        try {
            $fields = Validator::validate($request::body(), [
                'nome' => ['required', 'string', 'min:3', 'max:255'],
                'descricao' => ['required', 'string', 'min:3', 'max:255'],
            ]);

            $classService = FiapClassService::update($id[0], $fields);

            if (isset($classService['error'])) {
                return $response::error(message: $classService['error'], status: 400);
            }

            return $response::success(message: $classService, status: 200);
        } catch (ValidationException $e) {
            return $response::error(exception: $e, status: 422, params: ['errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function delete(Request $request, Response $response, array $id)
    {
        try {
            $classService = FiapClassService::delete($id[0]);

            if (isset($classService['error'])) {
                return $response::error(message: $classService['error'], status: 400);
            }

            return $response::success(data: ['message' => 'Class deleted successfully'], status: 200);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }
}
