<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 29.07.2019
 * Time: 18:47
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\controllers;


use api\versions\v1\components\CheckVerification;

class CheckController extends MainController
{

    /**
     * @return int|mixed
     * @throws \api\components\HttpException
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\httpclient\Exception
     * @throws \yii\mongodb\Exception
     */
    public function actionIndex()
    {
        $request = \Yii::$app->request;
        /** @var $component CheckVerification
         */
        $component = \Yii::$app->getModule('v1')->checkVerification;
        $model = $component->getModelCheck($request->get());
        $component->user_id = \Yii::$app->user->identity->getId();
        $model->created_at = time();
        $model->user_id = \Yii::$app->user->identity->getId();

        return $component->queryScanCheck($model);

    }

    /**
     * @return array
     * @throws \yii\base\InvalidConfigException
     */
    public function actionMychecks() {
		
        /** @var $component CheckVerification */
        $component = \Yii::$app->getModule('v1')->checkVerification;
        $component->user_id = \Yii::$app->user->identity->getId();
		
        return $component->getMyChecks();
    }

}