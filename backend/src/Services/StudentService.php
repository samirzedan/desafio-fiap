<?php

namespace App\Services;

use App\Models\Student;
use Exception;
use PDOException;

class StudentService
{
    public static function index(int $page = 1, ?string $query = null)
    {
        try {
            $students = Student::all($page, $query);

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

            $student = Student::save($fields);

            if (!$student) {
                return ['error' => 'Sorry, we could not create the student.'];
            }

            return "Student created successfully!";

        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            if ($e->errorInfo[0] === '23505') {
                return ['error' => 'Sorry, student already exists.'];
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
                return ['error' => 'Sorry, we could not update the student.'];
            }

            return "Student updated successfully!";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            if ($e->errorInfo[0] === '23505') {
                return ['error' => 'Sorry, student already exists.'];
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

    public static function assignToClass(int $id, int $class_id)
    {
        try {
            $updated = Student::assignToClass($id, $class_id);

            if (!$updated) {
                return ['error' => 'Sorry, we could not update the student.'];
            }

            return "Student updated successfully!";
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
