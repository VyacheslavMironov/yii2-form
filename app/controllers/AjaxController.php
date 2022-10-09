<?php

namespace app\controllers;

use Yii;
use app\models\User;

class AjaxController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\User';

    public function actionAdd() {
        $request = Yii::$app->request;
        return $this->asJson(array([
            'first_name' => $request->post('first_name'),
            'telephone' => $request->post('telephone'),
            'email' => $request->post('email')
        ])); 
    }

}
