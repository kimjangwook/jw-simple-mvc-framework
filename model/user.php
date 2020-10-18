<?php

namespace App\Model;

use PDOException;

class User extends Model
{
    public function getAll()
    {
        try {
            $pdo = $this->pdo;
            $stmt = $pdo->prepare("
                SELECT * FROM users
            ");
            $stmt->execute();

            return $stmt->fetchAll();
        } catch (PDOException $e) {
            die($e->getMessage());
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }
}