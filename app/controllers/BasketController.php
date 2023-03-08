<?php

namespace app\controllers;

use app\core\InitController;
use app\lib\UserOperations;
use app\models\BasketModel;

class BasketController extends InitController
{
    public function behaviors()
    {
        return [
            'access' => [
                'rules' => [
                    [
                        'actions' => ['list', 'add', 'update','delete'],
                        'roles' => [UserOperations::RoleUser],
                        'matchCallback' => function () {
                            $this->redirect('/user/profile');
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionList()
    {
        $this->view->title = 'Корзина';


        $this->render('list', [
            'sidebar' => UserOperations::getMenuLinks(),
            'products' => (new BasketModel())->getProductsByUserId($_SESSION['user']['id'])
        ]);
    }

    public function actionAdd()
    {
        $result = (new BasketModel())->add($_SESSION['user']['id'], $_GET['id']);
        if (!empty($result)) {
            $this->redirect('/products/list');
        }
    }

    public function actionUpdate()
    {
        $result = (new BasketModel())->changeCount($_POST['update_basket_id'], $_POST['basket_count']);

        if (!empty($result)) {
            $this->redirect('/basket/list');
        }

    }

    public function actionDelete()
    {
        $result = (new BasketModel())->deleteProduct($_GET['id']);
        if (!empty($result)) {
            $this->redirect('/basket/list');
        }
        echo $result;
    }

}
