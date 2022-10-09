<?php

use Yii;
use app\models\User;

class ModelTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public $first_name = 'Андрей';
    public $telephone = '88005553535';
    public $email = 'test.mailer@gmail.com';
    
    protected function _before()
    {
        $user = new User();
        $user->first_name = $this->first_name;
        $user->telephone = $this->telephone;
        $user->email = $this->email;
        $user->save();

        // Проверка параметров возвращаемого массива
        $this->assertArrayHasKey('first_name', $user);
        $this->assertArrayHasKey('telephone', $user);
        $this->assertArrayHasKey('email', $user);        
    }

    protected function _after()
    {
        // Проверка отправки почты
        $email = Yii::$app->mailer->compose()
            ->setFrom('vuacheslavmironov@yandex.ru')
            ->setTo('pamal78040@deitada.com')
            ->setSubject('Отправка тестового письма!')
            ->setHtmlBody($this->first_name.' '.$this->email.' '.$this->telephone)
            ->send();
        
        $this->assertEquals($email, true);
    }

    // tests
    public function testSomeFeature()
    {
        // Проверка контроллера
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'http://localhost:8080/ajax/add',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query(
                array(
                    'first_name' => $this->first_name,
                    'telephone' => $this->telephone,
                    'email' => $this->email,
                )
            )
        ));
        $response = curl_exec($curl);

        // $this->assertEquals(array_key_exists('message', $response), true);
        // $this->assertEquals($response['message'], 'Данные сохранены!');
    }
}