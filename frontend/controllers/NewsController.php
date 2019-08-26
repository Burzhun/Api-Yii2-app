<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 01.08.2019
 * Time: 1:48
 * Telegram: @JamalWeb
 */

namespace frontend\controllers;


use yii\web\Controller;

class NewsController extends Controller
{
    public $layout = 'news';

    public function actionIndex(){
        

        return $this->render('index');
    }

}