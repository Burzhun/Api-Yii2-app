<?php

/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 02.08.2019
 * Time: 19:38
 * Telegram: @JamalWeb
 */

/* @var $this \yii\web\View
 * @var $model \frontend\models\CheckForm
 */
use yii\widgets\MaskedInput;

$this->title = 'Проверить чек';
?>
<div class="container" style="padding: 30px">


    <? if(\Yii::$app->session->hasFlash('check_exist')): ?>
        <strong class="btn btn-danger"><?= \Yii::$app->session->getFlash('check_exist') ?></strong>
    <?endif;?>


    <? if(\Yii::$app->session->hasFlash('error_request')): ?>
        <strong class="btn btn-danger"><?= \Yii::$app->session->getFlash('error_request') ?></strong>
    <?endif;?>

    <h2><?= $this->title ?></h2>
    <i>Это тестовые данные валидного чека </i>
    <? $form = \yii\bootstrap\ActiveForm::begin() ?>

        <?= $form->field($model, 'fn')->widget(MaskedInput::className(),[
                'name' => 'fn',
                'mask' => '9999999999999999'
    ]) ?>

        <?= $form->field($model, 'fp')->widget(MaskedInput::className(),[
                'name' => 'fp',
                'mask' => '9999999999'
    ]) ?>

        <?= $form->field($model, 'i')->widget(MaskedInput::className(), [
                'name' => 'i',
                'mask' => '99999'
    ]) ?>

        <?= $form->field($model, 's')->textInput() ?>

        <?= $form->field($model, 't')->textInput() ?>

        <?= $form->field($model, 'n')->textInput() ?>

        <?= \yii\helpers\Html::submitButton('Отправить') ?>

    <? \yii\bootstrap\ActiveForm::end() ?>
</div>
