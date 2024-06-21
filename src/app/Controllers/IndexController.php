<?php

namespace App\Controllers;

class IndexController extends AbstractController
{
    public function handle(array $params = []): string
    {
        $select = 'user.first_name, user.second_name, products.title, products.price';

        $query = "SELECT {$select} FROM user INNER JOIN user_order ON user.id=user_order.user_id INNER JOIN products ON user_order.product_id=products.id ORDER BY products.title ASC, products.price DESC";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        $columnNames = ['Имя', 'Фамилия', 'Товар', 'Цена'];
        $content = \App\PageTemplateBuilder::makeTable($result, $columnNames);

        return \App\PageTemplateBuilder::makePageWrap('Таблица', $content);
    }
}