<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 16:39
 * Telegram: @JamalWeb
 */

namespace api\versions\v2\controllers;


use api\versions\v2\controllers\actions\user\{ActionAuth,ActionSignUp};
use common\models\localRecord\User;
use yii\filters\auth\HttpBasicAuth;

class UserController extends MainController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBasicAuth::class,
            'optional' => [
                'sign-up',
            ],
            'auth' => function($email, $password) {
                $user = User::findOne(['email' => $email]);
                if(empty($user)){
                    return null;
                }
                return $user->validatePassword($password) ? $user : null;
            }
        ];
        return $behaviors;
    }


    public function actions()
    {
        return [
            'auth'      => ['class' => ActionAuth::class],
            'sign-up'   => ['class' => ActionSignUp::class]
        ];
    }

    


}