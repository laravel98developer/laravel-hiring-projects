<?php

namespace Amir\Todolist\Models;

use Amir\Todolist\Database\DBConnection;

class BaseModel
{

    public $db;

    public function __construct()
    {
        $this->db = DBConnection::getInstance();
        DBConnection::setCharsetEncoding();
    }

}