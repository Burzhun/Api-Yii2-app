<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 29.07.2019
 * Time: 12:12
 * Telegram: @JamalWeb
 */

namespace api\versions\v1\models\requestModels\user;


use common\models\localRecord\User;
use yii\base\Model;

class UserRegistation extends Model
{
    private $_user;

    public $email;
    public $phone;
    public $gender;
    public $birthday;
    public $password;
    public $full_name;

   public function rules()
   {
       return [
           [['email','phone','birthday','password','full_name'],'string'],
           ['email','email'],
           ['gender', 'integer', 'max' => 1],
       ];
   }

    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }

    /**
     * @throws \yii\base\Exception
     */
    public function save() {
       if($this->validate()){
           $user = new User([
               'email'          => $this->email,
               'password_hash'  => $this->generatePassword($this->password),
               'phone'          => $this->phone,
               'birthday'       => $this->birthday,
               'full_name'      => $this->full_name,
               'gender'         => $this->gender,
               'auth_key'       => \Yii::$app->security->generateRandomString(),
               'status'         => 1,
           ]);
           if($user->save()){
               return true;
           }
           return $user->getFirstErrors();
       }
       return $this->getFirstErrors();
    }


    /**
     * @param $requestData
     * @return UserRegistation
     */
    public static function loadData($requestData) {
        $model = new static();
        $model->setAttributes($requestData);

        return $model;
    }

    /**
     * @param $password
     * @return string
     * @throws \yii\base\Exception
     */
    public function generatePassword($password){

        return \Yii::$app->security->generatePasswordHash($password);
    }

}