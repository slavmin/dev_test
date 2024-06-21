<?php

namespace App\Controllers;

abstract class AbstractController
{
    public function __construct(protected ?\PDO $dbConnection)
    {
        //
    }

    abstract public function handle(array $params = []): string|bool;
}