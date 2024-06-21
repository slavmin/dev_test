<?php

namespace App\Controllers;

use App\PageTemplateBuilder;

class FormController
{
    public function __construct(protected ?\PDO $dbConnection, protected PageTemplateBuilder $pageTemplateBuilder)
    {
        //
    }

    public function __invoke(): string
    {
        $content = \App\PageTemplateBuilder::makeForm();

        return \App\PageTemplateBuilder::makePageWrap('Форма', $content);
    }
}