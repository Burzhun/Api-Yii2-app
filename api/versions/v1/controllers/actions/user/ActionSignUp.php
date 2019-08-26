<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 17:14
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\controllers\actions\user;


use api\versions\v1\components\user\UserComponent;
use api\versions\v1\models\requestModels\user\UserRegistration;
use yii\web\BadRequestHttpException;

class ActionSignUp extends MainAction
{
    /**
     * @return array|bool
     * @throws \yii\base\Exception
     */
    public function run() {
        $request = \Yii::$app->request;
        /** @var $component UserComponent
         */

        if($request->isPost) {
            $model = UserRegistration::loadData($request->post());

            return $model->saveUser();
        }
		if($request->isGet) {
            $model = UserRegistration::loadData($request->get());

            return $model->saveUser();
        }
        throw new BadRequestHttpException('Не правильный метод запроса');

    }
}