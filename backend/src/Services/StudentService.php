<?php

namespace App\Services;

use App\Http\JWT;
use App\Models\Student;
use App\Utils\Validator;
use Exception;
use PDOException;

class StudentService
{
    public static function index(int $page = 1, ?string $query = null)
    {
        try {
            $limit = 10;
            $offset = ($page - 1) * $limit;

            $students = Student::all($limit, $offset, $query);

            if (empty($students['data'])) {
                return ['error' => 'Sorry, we could not find any student.'];
            }

            return $students;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function fetch(int $id)
    {
        try {
            $student = Student::find($id);

            if (!$student) {
                return ['error' => 'Sorry, we could not find the student.'];
            }

            return $student;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function create(array $fields)
    {
        try {
            $fields['senha'] = password_hash($fields['senha'], PASSWORD_DEFAULT);

            $user = Student::save($fields);

            if (!$user) {
                return ['error' => 'Sorry, we could not create your account.'];
            }

            return "User created successfully!";

        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            if ($e->errorInfo[0] === '23505') {
                return ['error' => 'Sorry, user already exists.'];
            }
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function update(int $id, array $fields)
    {
        try {
            if (isset($fields['senha'])) {
                $fields['senha'] = password_hash($fields['senha'], PASSWORD_DEFAULT);
            }

            $updated = Student::update($id, $fields);

            if (!$updated) {
                return ['error' => 'Sorry, we could not update the account.'];
            }

            return "User updated successfully!";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            if ($e->errorInfo[0] === '23505') {
                return ['error' => 'Sorry, user already exists.'];
            }
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function delete(int $id)
    {
        try {
            $deleted = Student::delete($id);

            if (!$deleted) {
                return ['error' => 'Student not found or could not be deleted.'];
            }

            return ['success' => true];
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }
}
