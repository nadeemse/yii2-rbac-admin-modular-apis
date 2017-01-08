<?php

class m161014_125856_items extends \yii\mongodb\Migration
{
    public function up()
    {
        $this->createCollection('items');
    }

    public function down()
    {
        $this->dropCollection('items');
    }
}
