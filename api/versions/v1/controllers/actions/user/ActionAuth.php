<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 16:49
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\controllers\actions\user;


use api\versions\v1\components\user\UserComponent;


class ActionAuth extends MainAction
{
    public function run(){
        /** @var $component UserComponent */
        $component  = \Yii::$app->getModule('v1')->user;
        $user_id    = null;
        if (!empty(\Yii::$app->user->identity)) {
            $user_id = \Yii::$app->user->identity->getId();
        }
        return $component->getTokenAuth($user_id);
    }

}