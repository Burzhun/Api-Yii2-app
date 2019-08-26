<?php
namespace frontend\models;

use common\models\localRecord\User;
use Yii;
use yii\base\Model;
use yii\db\Exception;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $full_name;
    public $email;
    public $password;
    public $phone;
    public $birthday;
    public $gender;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['full_name', 'trim'],
            ['full_name', 'required'],
            ['full_name', 'string', 'min' => 2, 'max' => 50],
            ['birthday', 'string'],
            ['phone', 'string', 'max' => 20],
            ['phone','trim'],
            ['phone','required'],
            ['phone', 'unique', 'targetClass' => 'common\models\localRecord\User', 'message' => 'Пользователь с таким телефоном уже существует'],
            ['gender','string'],
            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 30],
            ['email', 'unique', 'targetClass' => 'common\models\localRecord\User', 'message' => 'Этот адрес электронной почты уже был взят'],
            ['password', 'required'],
            ['password', 'string', 'min' => 6],
        ];
    }

    public function attributeLabels()
    {
        return [
            'phone'     => 'Номер телефона',
            'password'  => 'Пароль',
            'birthday'  => 'Дата рождения',
            'gender'    => 'Пол',
            'full_name' => 'ФИО'
        ];
    }

    /**
     * Signs user up.
     *
     * @return array|bool
     * @throws \yii\base\Exception
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->full_name = $this->full_name;
        $user->email = $this->email;
        $user->full_name = $this->full_name;
        $user->phone = $this->phone;
        $user->birthday = $this->birthday;
        $user->gender = $this->gender;
        $user->status = 1;
        $user->created_at = time();
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->generateEmailVerificationToken();
        try{
           if($user->save() && $this->sendEmail($user) ){
               return true;
           }
        }catch (Exception $exception){

        }


    }

    /**
     * Sends confirmation email to user
     * @param User $user user model to with email should be send
     * @return bool whether the email was sent
     */
    protected function sendEmail($user)
    {
        return Yii::$app
            ->mailer
            ->compose(
                ['html' => 'emailVerify-html', 'text' => 'emailVerify-text'],
                ['user' => $user]
            )
            ->setTo($this->email)
            ->setSubject('Регистрация аккаунта в  ' . Yii::$app->name)
            ->send();


    }
}
