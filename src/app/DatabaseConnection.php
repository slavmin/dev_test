<?php

namespace App;

final class DatabaseConnection
{
    private static ?\PDO $dbInstance = null;

    public static function getInstance(): ?\PDO
    {
        if (self::$dbInstance == null) {
            try {
                self::$dbInstance = new \PDO('mysql:host=mysql;dbname=developer', 'developer', 'secret');
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }

        return self::$dbInstance;
    }

    private function __construct()
    {
    }

    private function __clone()
    {
    }
}