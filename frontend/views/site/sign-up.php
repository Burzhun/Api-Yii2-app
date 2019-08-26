<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\SignupForm */
/* @var $user \common\models\localRecord\User */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Регистрация';
$session = Yii::$app->session;
?>
<div class="container" style="padding: 40px" id="sign_up">
    <div class="row">
        <? if($session->hasFlash('confirm_email')): ?>
            <? $user = $session->get('confirm_email') ?>
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Подтверждение email адреса</h4>

                <p>Уважаемый <?= $user->full_name ?> на ваш email: <?= $user->email ?> отправлено письмо для потверждения аккаунта </p>

            </div>

        <? endif; ?>
        <h1><?= $this->title ?></h1>
        <div class="col-lg-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

            <?= $form->field($model, 'full_name')->textInput(['autofocus' => true]) ?>

            <?= $form->field($model, 'email') ?>

            <?= $form->field($model, 'password')->passwordInput() ?>

            <?= $form->field($model, 'phone')->input('tel') ?>
            <?= $form->field($model, 'birthday')->input('date') ?>

            <?= $form->field($model, 'gender')->radioList([
                '1' => 'Мужской',
                '0' => 'Женский',
            ]) ?>

            <div class="form-group">
                <?= Html::submitButton('Зарегистрироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
