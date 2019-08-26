<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 19:09
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\components\user;

use common\models\localRecord\User;

class ProfileComponent extends BaseUserComponent
{

    public $api_formatter;
    public $user_model;

    public function infoProfile($user_id)
    {
        $user = $this->getUserByID($user_id);

        return $this->getAPIFormatter($user)->getInfoProfile();
    }

    /**
     * @param $user_id
     * @return array|bool
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function editProfile($user_id)
    {
        /** @var $user User */
        $user = $this->getUserByID($user_id);
        $user->setAttributes(\Yii::$app->request->post());
        if ($user->validate()) {
            if ($user->update()) {
                return true;
            } else {
                return $user->getFirstErrors();
            }
        }
        return $user->getFirstErrors();
    }

    public function getUserModel($param = null){
        /** @var $model User */
        $model =  new $this->user_model();
        if($param){
            $model->setAttributes($param);
        }
        return $model;
    }

    public function getAPIFormatter(User $user) {

        if(empty($user)) {
            return false;
        }
        /** @var $api_formatter APIFormatter */
        $api_formatter = new $this->api_formatter($user);
        return $api_formatter;
    }

}