<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 27.07.2019
 * Time: 17:08
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\models\requestModels\user;


use common\models\localRecord\User;
use yii\base\BaseObject;

class APIFormatter extends BaseObject
{
    /** @var $user */
    public $user;

    public function __construct(User $user,array $config = [])
    {
        $this->user = $user;
        parent::__construct($config);
    }

    public function getToken() {

        return [
            'id'        => $this->user->id,
            'token'     => $this->user->auth_key,
            'status'    => true
        ];
    }

    public function getInfoProfile() {
        return [
            'full_name'     => $this->user->full_name,
            'email'         => $this->user->email,
            'phone'         => $this->user->phone,
            'date'          => $this->user->birthday,
            'gender'        => ($this->user->gender == 1) ? "Мужской" : "Женский"
        ];
    }
}