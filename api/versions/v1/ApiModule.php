<?php

namespace api\versions\v1;

use yii\base\Module;
use yii\filters\auth\HttpBearerAuth;


class ApiModule extends Module
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
				'check/mychecks'
            ]
        ];

        return $behaviors;

    }
}
