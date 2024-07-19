<?php

namespace Amir\Todolist\Models;

use PDO;
use PDOException;

class TaskModel extends BaseModel
{
    const TABLE_NAME = "tasks";

    const STATUS = [
        "pending" => 0,
        "in-progress" => 1,
        "done" => 2,
    ];

    public function create($title, $description, $status = 0)
    {
        try {

            $statement = $this->db->prepare('
            INSERT INTO ' . self::TABLE_NAME . ' (title, description, status, created_at, updated_at)
                    VALUES (:title, :description, :status, :created_at, :updated_at)
                    ');

            $statement->execute([
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);

            return true;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }

    }

    public function update($id, $title, $description, $status)
    {
        try {
            $statement = $this->db->prepare('
            UPDATE  ' . self::TABLE_NAME . '
            SET title = :title, description = :description, status = :status, updated_at = :updated_at
            WHERE id = :id
            ');

            $statement->execute([
                'title' => $title,
                'description' => $description,
                'status' => $status,
                'updated_at' => date('Y-m-d H:i:s'),
                'id' => $id,
            ]);

            return true;
        } catch (\Exception $e) {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function getAll()
    {
        $sth = $this->db->prepare("SELECT * FROM " . self::TABLE_NAME);
        $sth->execute();

        return $sth->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function get($task_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM " . self::TABLE_NAME . " WHERE id=:id LIMIT 1");
        $stmt->execute([
            'id' => $task_id,
        ]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

}