<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \frontend\models\ResetPasswordForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Отправить письмо';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container" style="padding: 50px">
    <div class="site-resend-verification-email">
        <h1><?= Html::encode($this->title) ?></h1>
        <br>
        <p>Пожалуйста введите свой email для верификации аккаунта</p>
        <i> На вашу почту будет отправлена ссылка для верификации аккаунта </i>
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'resend-verification-email-form','action' => '/site/resend-verification-email']); ?>

                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

                <div class="form-group">
                    <?= Html::submitButton('Отправить', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>

