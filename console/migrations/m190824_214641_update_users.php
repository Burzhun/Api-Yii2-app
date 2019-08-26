<?php

use yii\db\Migration;

/**
 * Class m190824_214641_update_users
 */
class m190824_214641_update_users extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190824_214641_update_users cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190824_214641_update_users cannot be reverted.\n";

        return false;
    }
    */
}
