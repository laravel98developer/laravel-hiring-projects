<?php

namespace Amir\Todolist\Database;

use Amir\Todolist\Config\DBConfig;
use PDO;
use PDOException;


class DBConnection
{

    private static $instance;

    public static function getInstance()
    {

        if (empty(self::$instance)) {

            $db_info = DBConfig::getConfig();

            try {
                self::$instance = new PDO("mysql:host=" . $db_info['host'] . ';port=' . $db_info['port'] . ';dbname=' . $db_info['name'], $db_info['username'], $db_info['password']);
                self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$instance->query('SET NAMES utf8');
                self::$instance->query('SET CHARACTER SET utf8');

            } catch (PDOException $error) {
                echo $error->getMessage();
            }

        }

        return self::$instance;
    }

    public static function setCharsetEncoding()
    {
        if (self::$instance == null) {
            self::getInstance();
        }

        self::$instance->exec(
            "SET NAMES 'utf8';
			SET character_set_connection=utf8;
			SET character_set_client=utf8;
			SET character_set_results=utf8");
    }
}