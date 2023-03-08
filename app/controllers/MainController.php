<?php
namespace app\controllers;

use app\core\InitController;

class MainController extends InitController
{
    function actionIndex()
    {
        $this->render('index');
    }
    function __construct($route)
    {
        parent::__construct($route);
    }
}
