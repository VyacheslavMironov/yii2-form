<?php

namespace app\controllers;

use Yii;
use app\models\User;


class AjaxController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\User';

    public function actionAdd() {
        $request = Yii::$app->request;
        // Сохранение данных
        $user = new User();
        $user->first_name = $request->post('first_name');
        $user->telephone = $request->post('telephone');
        $user->email = $request->post('email');
        $user->save();

        if ($user->id) {
            // Текст письма
            $html = '<p>Имя: '.$user->first_name.'</p> <p>Телефон: '.$user->telephone.'</p><p>Эл. почта: '.$user->email.'</p>';
            // Отправка почты + возврат результата
            Yii::$app->mailer->compose()
            ->setFrom('vuacheslavmironov@yandex.ru')
            ->setTo('pamal78040@deitada.com')
            ->setSubject('Вам поступили новые данные!')
            ->setHtmlBody($html)
            ->send();
            return $this->asJson($user); 
        }
    }

}
