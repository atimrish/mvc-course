<?php

namespace app\models;

use app\core\BaseModel;
use PDO;

class ProductsModel extends BaseModel {

    public function getListProducts()
    {
        $result = null;

        $this->db->exec("CALL get_arrivals");
        $this->db->exec("CALL get_purchases");
        $this->db->exec("CALL get_products_in_basket({$_SESSION['user']['id']})");

        $products = $this->select("
            SELECT
                `products`.`id` AS product_id,
                `products`.`title` AS product_title,
                `products`.`description` AS product_description,
                `products`.`cost` AS product_cost,
                (`tmp_arrivals`.`arrivals_count` - `tmp_purchases`.`purchases_count`) AS product_count,
                `tmp_in_user_basket`.`in_basket` AS in_basket
            FROM `products`
            LEFT JOIN `tmp_arrivals` ON `products`.`id` = `tmp_arrivals`.`id`
            LEFT JOIN `tmp_purchases` ON `products`.`id` = `tmp_purchases`.`id`
            LEFT JOIN `tmp_in_user_basket` ON `products`.`id` = `tmp_in_user_basket`.`product_id`
            ;
            DROP TEMPORARY TABLE tmp_arrivals;
            DROP TEMPORARY TABLE tmp_purchases;
            DROP TEMPORARY TABLE tmp_in_user_basket;
        ");

        if (!empty($products)) {
            $result = $products;
        }

        return $result;
    }

    public function addNewProduct($title, $description, $count, $cost)
    {
        return $this->insert(
            "INSERT INTO products 
                (`title`, `description`, `count`, `cost`) 
                VALUES (:title, :description, :count, :cost)",
            [
                'title' => $title,
                'description' => $description,
                'count' => $count,
                'cost' => $cost
            ]
        );
    }

    public function updateProduct($id, $title, $description, $count, $cost)
    {
        return $this->update(
            "UPDATE `products`
            SET 
                `title` = '$title',
                `description` = '$description',
                `count` = '$count',
                `cost` = '$cost'
            WHERE `id` = '$id'", [
                'title' => $title,
                'description' => $description,
                'count' => $count,
                'cost' => $cost,
                'id' => $id
            ]
        );
    }

    public function deleteProduct($id)
    {
        return $this->delete(
            "DELETE FROM products WHERE `id` = :id",
            ['id' => $id]
        );
    }

    public function getProduct($id)
    {
        $this->db->exec("CALL get_arrivals;");
        $this->db->exec("CALL get_purchases;");

        return $this->select(
            "
                SELECT 
                    `products`.`id`,
                    `products`.`cost`,
                    `products`.`title`,
                    `products`.`description`,
                    (`tmp_arrivals`.`arrivals_count` - `tmp_purchases`.`purchases_count`) AS count
                FROM `products` 
                LEFT JOIN `tmp_arrivals` ON `products`.`id` = `tmp_arrivals`.`id`
                LEFT JOIN `tmp_purchases` ON `products`.`id` = `tmp_purchases`.`id`
                WHERE `products`.`id` = :id;
                
                DROP TEMPORARY TABLE tmp_arrivals;
                DROP TEMPORARY TABLE tmp_purchases;
                ",
            ['id' => $id]
        );
    }

}
