<?php

use yii\db\Migration;

class m161019_023003_cities extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%cities}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'country_id' => $this->integer()->notNull(),
            'city_code' => $this->string()->notNull(),
            'description' => $this->string(),
            'status' => $this->smallInteger(),
        ], $tableOptions);

        $this->createIndex('country_index', '{{%cities}}', 'country_id');
        $this->addForeignKey('country_fk', '{{%cities}}', 'country_id', 'country', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%cities}}');
    }
}
