<?php

namespace App\Models;

use PDO;

class Student extends Model
{
    public static function all(int $limit = 10, int $offset = 0, ?string $query = null)
    {
        $pdo = self::getConnection();

        $where = '';
        if ($query) {
            $where = "WHERE nome LIKE :query";
        }

        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM alunos $where");
        if ($query) {
            $countStmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
        }
        $countStmt->execute();
        $total = (int) $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $pdo->prepare("
            SELECT id, nome, data_nascimento, cpf, email
            FROM alunos
            $where
            ORDER BY nome ASC
            LIMIT :limit OFFSET :offset
        ");

        if ($query) {
            $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pages = (int) ceil($total / $limit);

        return [
            'total' => $total,
            'pages' => $pages,
            'data' => $students
        ];
    }

    public static function find(int $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            SELECT id, nome, data_nascimento, cpf, email FROM alunos
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function save(array $data)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO alunos (nome, data_nascimento, cpf, email, senha)
            VALUES (?, ?, ?, ?, ?)
        ");

        $stmt->execute([
            $data['nome'],
            $data['data_nascimento'],
            $data['cpf'],
            $data['email'],
            $data['senha'],
        ]);

        return $pdo->lastInsertId() > 0 ? true : false;
    }

    public static function update(int $id, array $data)
    {
        $pdo = self::getConnection();

        $fields = [];
        $values = [];

        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $values[] = $value;
        }

        if (empty($fields)) {
            return false;
        }

        $values[] = $id;

        $stmt = $pdo->prepare("
            UPDATE alunos
            SET " . implode(', ', $fields) . "
            WHERE id = ?
        ");

        $stmt->execute($values);

        return $stmt->rowCount() > 0;
    }

    public static function delete(int $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("DELETE FROM alunos WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
