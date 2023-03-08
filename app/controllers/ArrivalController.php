<?php

namespace app\controllers;

use app\core\InitController;
use app\lib\UserOperations;
use app\models\ArrivalModel;
use app\models\ProductsModel;

class ArrivalController extends InitController {

    public function behaviors()
    {
        return [
            'access' => [
                'rules' => [
                    [
                        'actions' => ['add'],
                        'roles' => [UserOperations::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/user/profile');
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionAdd()
    {
        $this->view->title = 'Приход товара';
        $error_msg = '';
        $post_data = $_POST['arrival'] ?? [];
        $data = [];
        foreach ($post_data as $key => $value) {
            if (!empty($value['included'])) {
                if (!empty($value['count'])) {
                    $data[] = [
                        'product_id' => $key,
                        'product_count' => $value['count']
                    ];
                } else {
                    $error_msg = 'Не указано количество товара';
                }
            }
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($data) && empty($error_msg)) {
            $res = (new ArrivalModel())->addArrival($data);

            if (!empty($res)) {
                $this->redirect('/products/list');
            }

        } else {

            $products = (new ProductsModel())->getListProducts();
            $this->render('add', [
                'sidebar' => UserOperations::getMenuLinks(),
                'products' => $products
            ]);
        }
    }

}