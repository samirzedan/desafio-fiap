<?php

namespace App\Models;

use PDO;

class FiapClass extends Model
{
    public static function all(int $page = 1, ?string $query = null)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $pdo = self::getConnection();

        $where = '';
        if ($query) {
            $where = "WHERE nome LIKE :query";
        }

        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM turmas $where");
        if ($query) {
            $countStmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
        }
        $countStmt->execute();
        $total = (int) $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $pdo->prepare("
            SELECT id, nome, descricao
            FROM turmas
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
            'current_page' => $page,
            'data' => $students
        ];
    }

    public static function find(int $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            SELECT id, nome, descricao FROM turmas
            WHERE id = ?
        ");

        $stmt->execute([$id]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function save(array $data)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            INSERT INTO turmas (nome, descricao)
            VALUES (?, ?)
        ");

        $stmt->execute([
            $data['nome'],
            $data['descricao'],
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
            UPDATE turmas
            SET " . implode(', ', $fields) . "
            WHERE id = ?
        ");

        $stmt->execute($values);

        return $stmt->rowCount() > 0;
    }

    public static function delete(int $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("DELETE FROM turmas WHERE id = :id");
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}
