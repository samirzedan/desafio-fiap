<?php

namespace App\Models;

use PDO;

class User extends Model
{
    public static function save(array $data)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO usuarios (nome, email, senha)
            VALUES (?, ?, ?)
        ");

        $stmt->execute([
            $data['nome'],
            $data['email'],
            $data['senha'],
        ]);

        return $pdo->lastInsertId() > 0 ? true : false;
    }

    public static function authentication(array $data)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            SELECT * FROM usuarios
            WHERE email = ?
        ");

        $stmt->execute([$data['email']]);

        if ($stmt->rowCount() < 1) {
            return false;
        }

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!password_verify($data['senha'], $user['senha'])) {
            return false;
        }

        return [
            'id'   => $user['id'],
            'nome' => $user['nome'],
            'email' => $user['email'],
        ];
    }

    public static function find(int $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare('
            SELECT id, nome, email FROM usuarios
            WHERE id = ?
        ');

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
