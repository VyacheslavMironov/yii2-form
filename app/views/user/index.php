<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\User $model */
/** @var ActiveForm $form */
?>
<div class="user-index">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'first_name', ['enableClientValidation' => false]) ?>
        <?= Html::tag('p', Html::encode(''), ['id' => 'first_nameError', 'style' => ['display' => 'none']]) ?>

        <?= $form->field($model, 'telephone', ['enableClientValidation' => false]) ?>
        <?= Html::tag('p', Html::encode(''), ['id' => 'telephoneError', 'style' => ['display' => 'none']]) ?>

        <?= $form->field($model, 'email', ['enableClientValidation' => false]) ?>
        <?= Html::tag('p', Html::encode(''), ['id' => 'emailError', 'style' => ['display' => 'none']]) ?>
    
        <div class="form-group">
            <?= Html::button('Отправить', ['id' => 'btn', 'class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

    <script type="text/javascript">
        // Проверка на правильность ввода имени
        function first_nameValid(first_name) {
            if (first_name.length >= 30) {
                return {error: 'Имя не должно привышать 30 символов!'}
            } else if (first_name.length == 0) {
                return {error: 'Это обязательное поле!'}
            } else {
                return {response: first_name}
            }
        }
        // Проверка номера на наличие цифр, символы или пустая строка не верное решение, лучше всё таки заполнит поле
        function telephoneValid(telephone) {
            return /^(\+7|7|8)?[\s\-]?\(?[489][0-9]{2}\)?[\s\-]?[0-9]{3}[\s\-]?[0-9]{2}[\s\-]?[0-9]{2}$/.test(telephone) ? {response: telephone} : {error: 'Телефон введён не правильно!'};
        }
        // Проверка на то что в email поле есть знак собаки и после неё так же есть символы
        function emailValid(email) {
            return (email.match(/.+?\@.+/g) || []).length === 1 ? {response: email} : {error: 'E-mail введён не правильно!'};
        }
        
        $( "#btn" ).click(function() {
            
            // Получение данных и обработка
            var first_name = first_nameValid($( 'input[id="user-first_name"]' ).val());
            var telephone = telephoneValid($( 'input[id="user-telephone"]' ).val());
            var email = emailValid($( 'input[id="user-email"]' ).val());

            // Если error то показывает ошибку под полем.
            if ('error' in first_name) {
                // Текст ошибки
                $( 'p[id="first_nameError"]' ).last().html( first_name.error );
                $( 'p[id="first_nameError"]' ).css( "display", "block" );
            } else {
                $( 'p[id="first_nameError"]' ).css( "display", "none" );
            }

            if ('error' in telephone) {
                // Текст ошибки
                $( 'p[id="telephoneError"]' ).last().html( telephone.error );
                $( 'p[id="telephoneError"]' ).css( "display", "block" );
            } else {
                $( 'p[id="telephoneError"]' ).css( "display", "none" );
            }

            if ('error' in email) {
                // Текст ошибки
                $( 'p[id="emailError"]' ).last().html( email.error );
                $( 'p[id="emailError"]' ).css( "display", "block" );
            } else {
                $( 'p[id="emailError"]' ).css( "display", "none" );
            }

            // отправка запроса
            $.ajax({
                url: 'http://localhost:8080/ajax/add',
                method: 'post',
		        dataType: 'json',
                data: {
                    'first_name': first_name.response,
                    'telephone': telephone.response,
                    'email': email.response
                },
                success: function (response) {
                    alert(response[0].message)
                    console.log(response)
                    // очистка полей
                    $( 'input[id="user-first_name"]' ).val('')
                    $( 'input[id="user-telephone"]' ).val('')
                    $( 'input[id="user-email"]' ).val('')
                },
                error: function (error) {
                    console.log(error)
                    alert('Ошибка сервера!')
                }
            });
        });

    </script>

</div><!-- user-index -->
