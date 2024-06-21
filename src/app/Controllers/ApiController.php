<?php

namespace App\Controllers;

class ApiController extends AbstractController
{
    public function handle(array $params = []): string
    {
        $select = 'user.first_name, user.second_name, products.title, products.price';

        $query = "SELECT {$select} FROM user INNER JOIN user_order ON user.id=user_order.user_id INNER JOIN products ON user_order.product_id=products.id ORDER BY products.title ASC, products.price DESC";
        $stmt = $this->dbConnection->prepare($query);
        $stmt->execute();
        $result = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        header_remove();
        header('Content-Type: application/json; charset=utf-8');
        return json_encode($result, JSON_UNESCAPED_UNICODE);
    }
}