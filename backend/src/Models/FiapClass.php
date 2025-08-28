<?php

namespace App\Models;

use PDO;

class FiapClass extends Model
{
    public static function allPaginate(int $page = 1, ?string $query = null)
    {
        $limit = 10;
        $offset = ($page - 1) * $limit;

        $pdo = self::getConnection();

        $where = '';
        if ($query) {
            $where = "WHERE t.nome LIKE :query";
        }

        $countStmt = $pdo->prepare("SELECT COUNT(*) as total FROM turmas t $where");
        if ($query) {
            $countStmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
        }
        $countStmt->execute();
        $total = (int) $countStmt->fetch(PDO::FETCH_ASSOC)['total'];

        $stmt = $pdo->prepare("
            SELECT 
                t.id, t.nome, t.descricao,
                COUNT(a.id) AS total_alunos
            FROM turmas t
            LEFT JOIN alunos a ON a.turma_id = t.id
            $where
            GROUP BY t.id, t.nome, t.descricao
            ORDER BY t.nome ASC
            LIMIT :limit OFFSET :offset
        ");

        if ($query) {
            $stmt->bindValue(':query', "%$query%", PDO::PARAM_STR);
        }
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);

        $stmt->execute();
        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $pages = (int) ceil($total / $limit);

        return [
            'total' => $total,
            'pages' => $pages,
            'current_page' => $page,
            'data' => $classes
        ];
    }

    public static function all()
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            SELECT 
                t.id, t.nome, t.descricao,
                COUNT(a.id) AS total_alunos
            FROM turmas t
            LEFT JOIN alunos a ON a.turma_id = t.id
            GROUP BY t.id, t.nome, t.descricao
            ORDER BY t.nome ASC
        ");

        $stmt->execute();
        $classes = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $classes;
    }

    public static function find(int $id)
    {
        $pdo = self::getConnection();

        $stmt = $pdo->prepare("
            SELECT id, nome, descricao
            FROM turmas
            WHERE id = ?
        ");
        $stmt->execute([$id]);
        $turma = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$turma) {
            return null;
        }

        $stmt = $pdo->prepare("
            SELECT nome, email
            FROM alunos
            WHERE turma_id = ?
            ORDER BY nome ASC
        ");
        $stmt->execute([$id]);
        $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $turma['alunos'] = $alunos;

        return $turma;
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
