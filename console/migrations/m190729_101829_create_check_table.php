<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%check}}`.
 */
class m190729_101829_create_check_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%check}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%check}}');
    }
}
