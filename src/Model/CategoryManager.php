<?php

namespace App\Model;

use PDO;

class CategoryManager extends AbstractManager
{
    public const TABLE = 'category';

    public function insert(array $category): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . "(name) VALUES (:name)");
        $statement->bindValue(':name', $category['name'], PDO::PARAM_STR);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
}
