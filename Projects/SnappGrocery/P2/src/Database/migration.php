<?php

namespace Amir\Todolist\Database;

require __DIR__ . "/../../vendor/autoload.php";

$conn = DBConnection::getInstance();

$tasks = "CREATE TABLE IF NOT EXISTS tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        status TINYINT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

$conn->exec($tasks);
