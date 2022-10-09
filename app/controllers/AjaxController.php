<?php

namespace app\controllers;

class AjaxController extends \yii\rest\ActiveController
{
    public function actionIndex()
    {
        return $this->render('index');
    }

}
