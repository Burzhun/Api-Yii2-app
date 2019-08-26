<?php
/**
 * Created by PhpStorm.
 * User: JamalAbsalimov
 * Date: 29.07.2019
 * Time: 12:12
 * Telegram: @JamalWeb
 */

namespace api\versions\v2\models\requestModels\user;


use api\components\HttpException;
use common\models\localRecord\User;
use yii\base\Model;
use yii\web\BadRequestHttpException;

class UserRegistration extends Model
{

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
    public function saveUser() {
       if($this->validate()){
           $user = new User([
               'email'          => $this->email,
               'password_hash'  => $this->generatePassword($this->password),
               'phone'          => $this->normalizePhone(),
               'birthday'       => $this->birthday,
               'full_name'      => $this->full_name,
               'gender'         => $this->gender,
               'auth_key'       => \Yii::$app->security->generateRandomString(),
               'status'         => 1,
           ]);
           if($user->save()){
               return $this->getAPIFormatter($user)->getToken();
           }
           throw new HttpException(400,'Validation Error',$user->getFirstErrors());
       }
        throw new HttpException(400,'Validation Error',$this->getFirstErrors());
    }


    /**
     * @param $requestData
     * @return UserRegistration
     */
    public static function loadData($requestData) {
        $model = new static();
        $model->setAttributes($requestData);

        return $model;
    }
    public function getAPIFormatter(User $user)
    {

        if (empty($user)) {
            return false;
        }
        /** @var $api_formatter APIFormatter */
        $api_formatter = new APIFormatter($user);
        return $api_formatter;
    }


    private function normalizePhone() {
        return  str_replace(["-", "(", ")", " ", "+", "_"], "", $this->phone);
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