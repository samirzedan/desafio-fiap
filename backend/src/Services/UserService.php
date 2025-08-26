<?php

namespace App\Services;

use App\Http\JWT;
use App\Utils\Validator;
use Exception;
use PDOException;
use App\Models\User;

class UserService
{
    public static function create(array $fields)
    {
        try {
            $fields['senha'] = password_hash($fields['senha'], PASSWORD_DEFAULT);

            $user = User::save($fields);

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

    public static function auth(array $fields)
    {
        try {
            $user = User::authentication($fields);

            if (!$user) {
                return ['error' => 'Sorry, we could not authenticate you.'];
            }

            return JWT::generate($user);
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
            $user = User::find($id);

            if (!$user) {
                return ['error' => 'Sorry, we could not find your account.'];
            }

            return $user;
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
