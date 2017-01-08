<?php

use yii\db\Migration;

class m161028_055152_item_location extends Migration
{
    public function up()
    {
        $this->addColumn('{{%items}}', 'area_id', 'INT(11) NOT NULL DEFAULT 0');
        $this->addColumn('{{%items}}', 'latitude', 'VARCHAR(100) DEFAULT NULL');
        $this->addColumn('{{%items}}', 'longitude', 'VARCHAR(100) DEFAULT NULL');
    }

    public function down()
    {
        $this->dropColumn('{{%items}}', 'area_id');
        $this->dropColumn('{{%items}}', 'latitude');
        $this->dropColumn('{{%items}}', 'longitude');
    }
}
