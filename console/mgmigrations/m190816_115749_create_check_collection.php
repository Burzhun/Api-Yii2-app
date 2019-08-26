<?php
namespace console\mgmigrations;
class m190816_115749_create_check_collection extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('check');
        $this->createIndex('check','fn',['unique'=> true]);

    }

    public function down()
    {
        $this->dropIndex('check','fn');
        $this->dropCollection('check');
    }
}
