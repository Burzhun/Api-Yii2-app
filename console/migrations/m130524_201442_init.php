<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%user}}', [
            'id'                    => $this->primaryKey(),
            'username'              => $this->string()->unique(),
            'full_name'             => $this->string(100)->notNull(),
            'birthday'              => $this->string(20),
            'gender'                => $this->tinyInteger(),
            'auth_key'              => $this->string(32)->notNull(),
            'phone'                 => $this->string(20)->unique(),
            'code'                  => $this->integer(6)->unique(),
            'password_hash'         => $this->string()->notNull(),
            'password_reset_token'  => $this->string()->unique(),
            'email'                 => $this->string()->unique(),
            'verification_token'    => $this->string()->defaultValue(null),
            'status'                => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at'            => $this->integer(),
            'updated_at'            => $this->integer(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('{{%user}}');
    }
}
