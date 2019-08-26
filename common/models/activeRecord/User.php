<?php

namespace common\models\activeRecord;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property string $full_name
 * @property string $birthday
 * @property int $gender
 * @property string $auth_key
 * @property string $phone
 * @property int $code
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $verification_token
 * @property int $status
 * @property int $created_at
 * @property int $updated_at
 */
class User extends \yii\db\ActiveRecord
{


    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[
                'full_name',
                'phone',
            ], 'required'],
            ['email','email'],
            [['gender', 'code', 'status', 'created_at', 'updated_at'], 'default', 'value' => null],
            [['gender', 'code', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'password_hash', 'password_reset_token', 'email', 'verification_token'], 'string', 'max' => 255],
            [['full_name'], 'string', 'max' => 100],
            [['birthday', 'phone'], 'string', 'max' => 20],
            [['auth_key'], 'string', 'max' => 32],
            [['code'], 'unique'],
            [['password_reset_token'], 'unique'],
            [['phone'], 'unique'],
            [['username'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'full_name' => 'Full Name',
            'birthday' => 'Birthday',
            'gender' => 'Gender',
            'auth_key' => 'Auth Key',
            'phone' => 'Phone',
            'code' => 'Code',
            'password_hash' => 'Password Hash',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'verification_token' => 'Verification Token',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
