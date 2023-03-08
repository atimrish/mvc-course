<?php

namespace app\controllers;

use app\core\InitController;
use app\lib\UserOperations;
use app\models\BasketModel;
use app\models\PurchaseModel;

class PurchaseController extends InitController
{

    public function behaviors()
    {
        return [
            'access' => [
                'rules' => [
                    [
                        'actions' => ['form'],
                        'roles' => [UserOperations::RoleUser],
                        'matchCallback' => function () {
                            $this->redirect('/user/profile');
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionForm()
    {
        $this->view->title = 'Оформление заказа';
        $error_msg = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['btn_purchase'])) {
            $data = $_POST['purchase'];
            if (!empty($data)) {
                foreach ($data as $key => $value) {
                    if (empty($value)) {
                        $error_msg[$key] = '1';
                    }
                }
            }

            if (empty($error_msg)) {
                $basket_model = new BasketModel();
                $basket = $basket_model->getProductsByUserId($_SESSION['user']['id']);


                $result = (new PurchaseModel())->purchase($data, $basket);


                if (!empty($result)) {
                    $basket_model->deleteProductsByUserId($_SESSION['user']['id']);
                    $this->redirect('/user/profile');
                } else {
                    print_r($error_msg);
                    die();
                }

            }

        }


        $this->render('form', [
            'sidebar' => UserOperations::getMenuLinks(),
            'error_msg' => $error_msg
        ]);
    }


}
