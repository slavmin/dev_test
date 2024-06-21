<?php

namespace App\Controllers;

abstract class AbstractController
{
    protected ?\PDO $dbConnection;

    public function __construct()
    {
        $this->dbConnection = \App\DatabaseConnection::getInstance();
    }

    abstract public function handle(array $params = []): string|bool;
}