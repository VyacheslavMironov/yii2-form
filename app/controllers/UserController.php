<?php

namespace app\controllers;

use app\models\User;

class UserController extends \yii\web\Controller
{
    // public $modelClass = 'app\models\User';

    public function actionIndex()
    {
        return $this->render('index', ['model' => new User()]);
    }

}
