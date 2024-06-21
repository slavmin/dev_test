<?php

namespace App\Controllers;

use App\PageTemplateBuilder;

abstract class AbstractController
{
    public function __construct(protected ?\PDO $dbConnection, protected PageTemplateBuilder $pageTemplateBuilder)
    {
        //
    }

    abstract public function handle(array $params = []): string|bool;
}