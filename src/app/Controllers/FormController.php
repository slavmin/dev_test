<?php

namespace App\Controllers;

class FormController extends AbstractController
{
    public function handle(array $params = []): string
    {
        $content = \App\PageTemplateBuilder::makeForm();

        return \App\PageTemplateBuilder::makePageWrap('Форма', $content);
    }
}