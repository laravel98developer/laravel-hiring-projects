<?php


namespace Amir\Todolist\Config;

class DBConfig
{

    public static function getConfig()
    {
        return [
            "host" => "db",
            "port" => "3306",
            "name" => "main",
            "username" => "username",
            "password" => "password",
        ];
    }

}

