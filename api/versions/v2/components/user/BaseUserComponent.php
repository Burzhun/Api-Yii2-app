<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 19:10
 * Telegram: @JamalWeb
 */

namespace api\versions\v2\components\user;


use api\versions\v2\models\requestModels\user\APIFormatter;
use common\models\localRecord\User;
use yii\base\Component;

class BaseUserComponent extends Component
{
    /** @var $api_formatter APIFormatter */
    public $api_formatter;

    /** @var $user_model User*/
    public $user_model;
    /**
     * @return string
     * @throws \yii\base\Exception
     */
    public function generateAuthKey(){

        return \Yii::$app->security->generateRandomString();
    }

    /**
     * @param $password
     * @return string
     * @throws \yii\base\Exception
     */
    public function generatePassword($password){

        return \Yii::$app->security->generatePasswordHash($password);
    }


    public function getUserByID($id){

        return $this->getUserModel()::findOne($id);
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