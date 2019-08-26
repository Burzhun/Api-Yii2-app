<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 16:39
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\controllers;


use common\models\activeRecord\User;
use yii\web\Controller;

class MainController extends Controller
{


    public function actionIndex() {

        return User::find()->asArray()->count();
    }
}