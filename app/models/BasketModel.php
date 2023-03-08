<?php

namespace app\models;

use app\core\BaseModel;

class BasketModel extends BaseModel
{

    public function add($user_id, $product_id)
    {
        return $this->insert(
            "
                INSERT INTO 
                    `basket` 
                    (user_id, product_id) 
                VALUES (:user_id, :product_id)", [
            'user_id' => $user_id,
            'product_id' => $product_id
        ]);
    }

    public function getProductsByUserId($user_id)
    {
        $this->db->exec("CALL get_arrivals;");
        $this->db->exec("CALL get_purchases;");

        return $this->select(
            "
                SELECT 
                    `basket`.`id` AS id,
                    `basket`.`count` AS in_basket_count,
                    `products`.`id` AS product_id,
                    `products`.`title` AS product_title,
					(`tmp_arrivals`.`arrivals_count` - `tmp_purchases`.`purchases_count`) AS product_count,
                    `products`.`cost` AS product_cost
                FROM `basket` 
                LEFT JOIN `products` ON `basket`.`product_id` = `products`.`id`
                LEFT JOIN `tmp_arrivals` ON `basket`.`product_id` = `tmp_arrivals`.`id`
                LEFT JOIN `tmp_purchases` ON `basket`.`product_id` = `tmp_purchases`.`id`
                WHERE `basket`.`user_id` = :user_id;
                DROP TEMPORARY TABLE `tmp_arrivals`;
                DROP TEMPORARY TABLE `tmp_purchases`;", [
            'user_id' => $user_id
        ]);
    }

    public function changeCount($id, $count)
    {
        $result = $this->update(
            "UPDATE `basket`
            SET
                `count` = '$count'
            WHERE `id` = '$id'
        ");

        if ($result) {
            return 'suc';
        } else {
            return $this->db->errorCode();
        }
    }

    public function deleteProduct($id)
    {
        return $this->delete("DELETE FROM `basket` WHERE `id` = '$id'");
    }

    public function deleteProductsByUserId($id)
    {
        return $this->delete("DELETE FROM `basket` WHERE `user_id` = :user_id", [
            'user_id' => $id
            ]
        );
    }

}
