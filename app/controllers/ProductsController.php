<?php

namespace app\controllers;

use app\core\InitController;
use app\lib\UserOperations;
use app\models\ProductsModel;

class ProductsController extends InitController {

    public function behaviors()
    {
        return [
            'access' => [
                'rules' => [
                    [
                        'actions' => ['products', 'product'],
                        'roles' => [UserOperations::RoleGuest, UserOperations::RoleUser, UserOperations::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/products/list');
                        }
                    ],
                    [
                        'actions' => ['add', 'update', 'delete'],
                        'roles' => [UserOperations::RoleAdmin],
                        'matchCallback' => function () {
                            $this->redirect('/products/list');
                        }
                    ]
                ]
            ]
        ];
    }

    public function actionAdd()
    {
        $this->view->title = 'Добавление продукта';
        $error_message = [];
        $product_data = [];

        if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['btn_add_product'])) {
            $product_data = !empty($_POST['product']) ? $_POST['product'] : null;

            if(!empty($product_data)) {

                if (empty($product_data['title'])) {
                    $error_message['title'] = 'Это обязательное поле';
                }
                if (empty($product_data['description'])) {
                    $error_message['description'] = 'Это обязательное поле';
                }
                if (empty($product_data['cost'])) {
                    $error_message['cost'] = 'Это обязательное поле';
                }

                if (empty($error_message)) {
                    $products_model = new ProductsModel();
                    $result = $products_model->addNewProduct(
                        $product_data['title'],
                        $product_data['description'],
                        $product_data['count'],
                        $product_data['cost']
                    );

                    if ($result) {
                        $this->redirect('/products/list');
                    }
                }
            }
        }

        $this->render('add', [
            'sidebar' => UserOperations::getMenuLinks(),
            'error_msg' => $error_message,
            'product_data' => $product_data
        ]);
    }

    public function actionUpdate()
    {
        $this->view->title = 'Изменение продукта';
        $error_msg = [];
        $product_data_update = !empty($_POST['product']) ? $_POST['product'] : null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($product_data_update)) {
            if (empty($product_data_update['title'])) {
                $error_msg['title'] = '1';
            }
            if (empty($product_data_update['description'])) {
                $error_msg['description'] = '1';
            }
            if (empty($product_data_update['cost'])) {
                $error_msg['cost'] = '1';
            }

            if (empty($error_msg)) {
                $products_model = new ProductsModel();
                $result = $products_model->updateProduct(
                    $_GET['id'],
                    $product_data_update['title'],
                    $product_data_update['description'],
                    $product_data_update['count'],
                    $product_data_update['cost']
                );

                if (!empty($result)) {
                    $this->redirect('/products/list');
                }
            }

        }

        $this->render('update', [
            'sidebar' => UserOperations::getMenuLinks(),
            'error_msg' => $error_msg,
            'product' => (new ProductsModel())->getProduct($_GET['id'])[0]
        ]);

    }

    public function actionDelete()
    {
        (new ProductsModel())->deleteProduct($_GET['id']);
        $this->redirect('/products/list');
    }

    public function actionList()
    {
        $this->view->title = 'Продукты';

        $products_model = new ProductsModel();
        $products = $products_model->getListProducts();



        $this->render('list', [
            'sidebar' => UserOperations::getMenuLinks(),
            'products' => $products,
            'role' => UserOperations::getRoleUser()
        ]
        );
    }

    public function actionProduct()
    {
        $id = $_GET['id'];
        $this->render('product', [
            'sidebar' => UserOperations::getMenuLinks(),
            'product' => (new ProductsModel())->getProduct($id)[0],
            'role' => UserOperations::getRoleUser()
        ]);
    }
    
}
