<?php

namespace app\models;

use app\core\BaseModel;

class PurchaseModel extends BaseModel {

    public function purchase($data, $products)
    {
        $total = 0;
        foreach ($products as $item) {
            $total += $item['product_count'] * $item['product_cost'];
        }


        $this->insert(
            "INSERT INTO `purchase`(
                       `user_id`,
                       `total_price`,
                       `surname`,
                       `name`,
                       `patronymic`,
                       `address`,
                       `email`
                       )
                VALUES(
                       {$_SESSION['user']['id']},
                       '$total',
                       '{$data['surname']}',
                       '{$data['name']}',
                       '{$data['patronymic']}',
                       '{$data['address']}',
                       '{$data['email']}'
                       )"
        );



        $id = $this->db->lastInsertId();
        $sql = "INSERT INTO `purchase_products` (`purchase_id`, `product_id`, `product_count`) VALUES ";

        for ($i = 0; $i < count($products) - 1; $i++) {
            $sql .= " ('$id', '{$products[$i]['product_id']}', '{$products[$i]['product_count']}'),";
        }
        $sql .= " ('$id', '{$products[count($products) - 1]['product_id']}', '{$products[count($products) - 1]['in_basket_count']}')";

        return $this->insert($sql);
    }

}
