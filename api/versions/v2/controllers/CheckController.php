<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 29.07.2019
 * Time: 18:47
 * Telegram: @JamalWeb
 */

namespace api\versions\v2\controllers;

use yii\web\Controller;
use api\versions\v2\components\CheckVerification;
use api\versions\v2\models\requestModels\check\Check;

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
        $component = \Yii::$app->getModule('v2')->checkVerification;
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
    public function actionMycheck() {
        /** @var $component CheckVerification */
        $component = \Yii::$app->getModule('v2')->checkVerification;
        $component->user_id = \Yii::$app->user->identity->getId();

        return $component->getMyChecks();
    }

}