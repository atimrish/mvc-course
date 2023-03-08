<?php

namespace app\models;

use app\core\BaseModel;

class ArrivalModel extends BaseModel {

    public function addArrival($data)
    {
            $this->insert("INSERT INTO `arrival`() VALUES ()");
            $id = $this->db->lastInsertId();

            $sql = "INSERT INTO `arrival_products`(`arrival_id`, `product_id`, `count`) 
                    VALUES ('$id',
                            {$data[0]['product_id']},
                            {$data[0]['product_count']}
                            )";
            for ($i = 1; $i < count($data); $i++) {
                $sql .= ", ('$id',  {$data[$i]['product_id']}, {$data[$i]['product_count']})";
            }

            return $this->insert($sql);
    }


}



