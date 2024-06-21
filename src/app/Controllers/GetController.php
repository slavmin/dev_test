<?php

namespace App\Controllers;

use App\PageTemplateBuilder;

class GetController
{
    public function __construct(protected ?\PDO $dbConnection, protected PageTemplateBuilder $pageTemplateBuilder)
    {
        //
    }

    public function __invoke(array $params): string
    {
        $in = str_repeat('?,', count($params) - 1) . '?';
        $select = 'user.first_name, user.second_name, products.title, products.price';

        $query = "SELECT {$select} FROM user INNER JOIN user_order ON user.id=user_order.user_id INNER JOIN products ON user_order.product_id=products.id WHERE user.id IN ($in) ORDER BY products.title ASC, products.price DESC";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute($params);
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $columnNames = ['Имя', 'Фамилия', 'Товар', 'Цена'];
        $content = \App\PageTemplateBuilder::makeTable($result, $columnNames);

        return \App\PageTemplateBuilder::makePageWrap('Таблица', $content);
    }
}