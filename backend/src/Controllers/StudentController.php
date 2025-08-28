<?php

namespace App\Controllers;

use App\Exceptions\ValidationException;
use App\Http\Request;
use App\Http\Response;
use App\Services\StudentService;
use App\Utils\Validator;
use Exception;

class StudentController
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

            $studentService = StudentService::index($page, $query);

            if (isset($studentService['error'])) {
                return $response::error(message: $studentService['error'], status: 400);
            }

            return $response::success(data: $studentService, status: 200);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function fetch(Request $request, Response $response, array $id)
    {
        try {
            $studentService = StudentService::fetch($id[0]);

            if (isset($studentService['error'])) {
                return $response::error(message: $studentService['error'], status: 400);
            }

            return $response::success(data: $studentService, status: 200);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function store(Request $request, Response $response)
    {
        try {
            $fields = Validator::validate($request::body(), [
                'nome' => ['required', 'string', 'min:3', 'max:255'],
                'data_nascimento' => ['required', 'date'],
                'cpf' => ['required', 'string', 'cpf'],
                'email' => ['required', 'email', 'max:255'],
                'senha' => ['required', 'string', 'strong_password', 'min:8', 'max:255'],
            ]);

            $studentService = StudentService::create($fields);

            if (isset($studentService['error'])) {
                return $response::error(message: $studentService['error'], status: 400);
            }

            return $response::success(message: $studentService, status: 201);
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
                'data_nascimento' => ['required', 'date'],
                'cpf' => ['required', 'string', 'cpf'],
                'email' => ['required', 'email', 'max:255'],
            ]);

            $studentService = StudentService::update($id[0], $fields);

            if (isset($studentService['error'])) {
                return $response::error(message: $studentService['error'], status: 400);
            }

            return $response::success(message: $studentService, status: 200);
        } catch (ValidationException $e) {
            return $response::error(exception: $e, status: 422, params: ['errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function delete(Request $request, Response $response, array $id)
    {
        try {
            $studentService = StudentService::delete($id[0]);

            if (isset($studentService['error'])) {
                return $response::error(message: $studentService['error'], status: 400);
            }

            return $response::success(data: ['message' => 'Student deleted successfully'], status: 200);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }

    public function assignToClass(Request $request, Response $response, array $id)
    {
        try {
            $fields = Validator::validate($request::body(), [
                'class_id' => ['required', 'numeric', 'integer', 'min:1'],
            ]);

            $studentService = StudentService::assignToClass($id[0], $fields['class_id']);

            if (isset($studentService['error'])) {
                return $response::error(message: $studentService['error'], status: 400);
            }

            return $response::success(data: ['message' => 'Student deleted successfully'], status: 200);
        } catch (ValidationException $e) {
            return $response::error(exception: $e, status: 422, params: ['errors' => $e->getErrors()]);
        } catch (Exception $e) {
            return $response::error(exception: $e);
        }
    }
}
