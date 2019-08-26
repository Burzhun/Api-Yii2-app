<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 19:01
 * Telegram: @JamalWeb
 */

namespace api\versions\v2\controllers\actions\profile;


use api\versions\v2\components\user\ProfileComponent;
use yii\base\Action;

class ActionInfo extends Action
{
    public function run() {
        /** @var $component ProfileComponent */
        $component = \Yii::$app->getModule('v2')->profile;
        $user_id   = \Yii::$app->user->identity->getId();
        return $component->infoProfile($user_id);
    }


}