<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 01.08.2019
 * Time: 2:20
 * Telegram: @JamalWeb
 */

namespace frontend\controllers;


use yii\web\Controller;

class PrivateController extends Controller
{

    public  $layout = 'policy';
    public function actionPolicy() {

        return $this->render('policy');
    }

}