<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 20.07.2019
 * Time: 18:03
 * Telegram: @JamalWeb
 */

namespace console\controllers;


use common\models\localRecord\User;
use yii\console\Controller;

class UserController extends Controller
{
    /**
     * @throws \yii\base\Exception
     */
    public function actionInit()
    {

        $user = new User([

            'full_name'     => 'admin',
            'auth_key'      => \Yii::$app->security->generateRandomString(),
            'email'         => 'admin_tax@email.ru',
            'phone'         => '79898707217',
            'gender'        => 1,
            'birthday'      => '12/03/2019',
            'password_hash' => \Yii::$app->security->generatePasswordHash('rue0KhR7Wgw3fCC'),
            'created_at'    => time(),
            'status'        => 5

        ]);

        return $user->save();
    }

    /**
     * @throws \Throwable
     * @throws \yii\base\Exception
     * @throws \yii\db\StaleObjectException
     */
    public function actionGus()
    {

        $user = User::findOne(['email' => 'gadzhi@gasanov.pro']);


        $this->stdout("$user->id");
    }

}