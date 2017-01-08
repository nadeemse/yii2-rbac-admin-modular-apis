<?php

use yii\db\Migration;

class m161019_023017_areas extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%areas}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'city_id' => $this->integer()->notNull(),
            'area_code' => $this->integer()->notNull(),
            'description' => $this->string(),
            'status' => $this->smallInteger(),
        ], $tableOptions);

        $this->createIndex('city_index', '{{%areas}}', 'city_id');
        $this->addForeignKey('city_fk', '{{%areas}}', 'city_id', 'cities', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%areas}}');
    }
}
