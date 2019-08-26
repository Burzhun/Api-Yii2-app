<?php

namespace api\versions\v2;

use yii\base\Module;
use yii\filters\auth\HttpBearerAuth;


class ApiModule2 extends Module
{
    public function init()
    {
        parent::init();
    }


    public function behaviors()
    {
        $behaviors =  parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => HttpBearerAuth::class,
            'optional' => [
                'user/sign-up',
                'user/auth',
                'main/index',
                'main/sendsms',
				'main/checkcode',
				'main/complaint',
				'check/mycheck'
            ]
        ];

        return $behaviors;

    }
}
