<?php

namespace App\Services;

use App\Models\FiapClass;
use Exception;
use PDOException;

class FiapClassService
{
    public static function index(int $page = 1, ?string $query = null)
    {
        try {
            $classs = FiapClass::allPaginate($page, $query);

            return $classs;
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function indexAll()
    {
        try {
            $classs = FiapClass::all();

            return $classs;
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
            $class = FiapClass::find($id);

            if (!$class) {
                return ['error' => 'Sorry, we could not find the class.'];
            }

            return $class;
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
            $class = FiapClass::save($fields);

            if (!$class) {
                return ['error' => 'Sorry, we could not create the class.'];
            }

            return "Class created successfully!";

        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            if ($e->errorInfo[0] === '23505') {
                return ['error' => 'Sorry, class already exists.'];
            }
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function update(int $id, array $fields)
    {
        try {
            $updated = FiapClass::update($id, $fields);

            if (!$updated) {
                return ['error' => 'Sorry, we could not update the class.'];
            }

            return "Class updated successfully!";
        } catch (PDOException $e) {
            if ($e->errorInfo[0] === '08006') {
                return ['error' => 'Sorry, we could not connect to the database.'];
            }
            if ($e->errorInfo[0] === '23505') {
                return ['error' => 'Sorry, class already exists.'];
            }
            return ['error' => $e->errorInfo[0]];
        } catch (Exception $e) {
            return ['error' => $e->getMessage()];
        }
    }

    public static function delete(int $id)
    {
        try {
            $deleted = FiapClass::delete($id);

            if (!$deleted) {
                return ['error' => 'Class not found or could not be deleted.'];
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
