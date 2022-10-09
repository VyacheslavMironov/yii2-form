<?php

namespace app\controllers;

use Yii;
use app\models\User;
use yii\filters\Cors;


class AjaxController extends \yii\rest\ActiveController
{
    public $modelClass = 'app\models\User';

    public $enableCsrfValidation = false;

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['corsFilter'] = [
            'class' => Cors::class,
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Allow-Origin' => ['*'],
                'Access-Control-Request-Methods' => ['POST', 'GET', 'PUT', 'DELETE', 'OPTIONS'],
                'Access-Control-Max-Age' => 3600,
                'Access-Control-Expose-Headers' => ['X-Pagination-Current-Page'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Allow-Headers' => ['X-Requested-With', 'Content-Type', 'Accept', 'Authorization'],
                #'Access-Control-Expose-Headers' => ['*'],
            ],
        ];
        return $behaviors;
    }

    public function actionAdd() {
        $this->behaviors();
        $request = Yii::$app->request;
        // Сохранение данных
        $user = new User();
        $user->first_name = $request->post('first_name');
        $user->telephone = $request->post('telephone');
        $user->email = $request->post('email');
        $user->save();
        if ($user->save()) {
            // Текст письма
            $html = '<p>Имя: '.$request->post('first_name').'</p> <p>Телефон: '.$request->post('telephone').'</p><p>Эл. почта: '.$request->post('email').'</p>';
            // Отправка почты + возврат результата
            Yii::$app->mailer->compose()
                ->setFrom('vuacheslavmironov@yandex.ru')
                ->setTo('pamal78040@deitada.com')
                ->setSubject('Вам поступили новые данные!')
                ->setHtmlBody($html)
                ->send();
            return $this->asJson(array(['message' => 'Данные сохранены!'])); 
        } else {
            return $this->asJson(array(['message' => 'Ошибка сохранения данных!'])); 
        }
    }

}
