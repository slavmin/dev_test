<?php

namespace App\Controllers;

use App\PageTemplateBuilder;
use http\Exception\InvalidArgumentException;

class PostController
{
    public function __construct(protected ?\PDO $dbConnection, protected PageTemplateBuilder $pageTemplateBuilder)
    {
        //
    }

    public function __invoke(array $params): bool
    {
        $data = [];

        $titlesArr = array_filter($params['title']);

        $pricesArr = array_filter($params['price']);

        foreach ($titlesArr as $key => $value) {
            if (array_key_exists($key, $pricesArr)) {
                $data[] = [$value, $pricesArr[$key]];
            }
        }

        $data = array_filter($data);

        if (empty($data)) {
            return false;
        }

        $values = str_repeat('?,', count($data[array_key_first($data)]) - 1) . '?';

        $query = 'INSERT INTO products (title, price) VALUES ' . str_repeat("($values),", count($data) - 1) . "($values)";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute(array_merge(...$data));

        return true;
    }
}