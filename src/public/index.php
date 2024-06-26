<?php
// Подключаем файлы
require_once __DIR__ . '/../app/DatabaseConnection.php';
require_once __DIR__ . '/../app/PageTemplateBuilder.php';
require_once __DIR__ . '/../app/Controllers/AbstractController.php';
require_once __DIR__ . '/../app/Controllers/IndexController.php';
require_once __DIR__ . '/../app/Controllers/GetController.php';
require_once __DIR__ . '/../app/Controllers/FormController.php';
require_once __DIR__ . '/../app/Controllers/PostController.php';
require_once __DIR__ . '/../app/Controllers/ApiController.php';

// Метод запроса
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Урл запроса
$url = explode('?', $_SERVER['REQUEST_URI']);
$urlBaseName = pathinfo($url[0], PATHINFO_BASENAME);

$pageContent = \App\PageTemplateBuilder::makePageWrap('Not found', '<h1>Ничего не найдено</h1>');

if ($requestMethod === 'GET') {
    if ($urlBaseName === 'form') {
        $pageContent = (new \App\Controllers\FormController())->handle();
    } elseif ($urlBaseName === 'api') {
        $pageContent = (new \App\Controllers\ApiController())->handle();
    } else {
        $requestBody = filter_input_array(INPUT_GET, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        if (is_array($requestBody) && array_key_exists('users', $requestBody)) {
            $pageContent = (new \App\Controllers\GetController())->handle($requestBody['users']);
        } else {
            $pageContent = (new \App\Controllers\IndexController())->handle();
        }
    }
}

if ($requestMethod === 'POST') {
    $requestBody = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if (is_array($requestBody) && array_key_exists('title', $requestBody) && array_key_exists('price', $requestBody)) {
        if (count($requestBody['title']) === count($requestBody['price'])) {
            $isSaved = (new \App\Controllers\PostController())->handle($requestBody);

            $pageContent = \App\PageTemplateBuilder::makePageWrap('Bad Request', '<h1>Bad Request</h1><nav class="nav nav-pills nav-fill"><a class="nav-link" href="/form">Форма</a></nav>');

            if ($isSaved) {
                header('Location: /');
            }
        }
    }
}

exit($pageContent);