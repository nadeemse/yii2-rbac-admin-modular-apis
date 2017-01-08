<?php

use yii\db\Migration;

class m161028_061702_item_area_foreign_key extends Migration
{
    public function up()
    {
        $this->createIndex('area_index', '{{%items}}', 'area_id');
        $this->addForeignKey('area_fk', '{{%items}}', 'area_id', 'cities', 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropForeignKey('area_fk', '{{%items}}');
        $this->dropIndex('area_index', '{{%items}}');
    }
}
