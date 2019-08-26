<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 16:54
 * Telegram: @JamalWeb
 */

namespace api\versions\v2\components\user;

use api\versions\v2\models\requestModels\user\APIFormatter;
use common\models\localRecord\User;

class UserComponent extends BaseUserComponent
{

    public $api_formatter;
    /** @var $user_model */
    public $user_model;

    /**
     * @param User $user
     * @return array|bool
     * @throws \yii\base\Exception
     */
    public function signUp(User $user)
    {
        $user->auth_key         = $this->generateAuthKey();
        $user->password_hash    = $this->generatePassword($user->password);
        $user->status           = 1;
        if ($user->validate()) {
            if($user->save()){
                return $this->getAPIFormatter($user)->getToken();
            }
            return $user->getFirstErrors();
        }
        return $user->getFirstErrors();
    }

    public function getTokenAuth($user_id)
    {
        $user = $this->getUserByID($user_id);

        return $this->getAPIFormatter($user)->getToken();
    }

    public function getUserByID($id)
    {

        return $this->getUserModel()::findOne($id);
    }


    public function getUserModel($param = null)
    {
        /** @var $model User */
        $model = new $this->user_model();
        if ($param) {
            $model->setAttributes($param);
        }
        return $model;
    }

    public function getAPIFormatter(User $user)
    {

        if (empty($user)) {
            return false;
        }
        /** @var $api_formatter APIFormatter */
        $api_formatter = new $this->api_formatter($user);
        return $api_formatter;
    }


}