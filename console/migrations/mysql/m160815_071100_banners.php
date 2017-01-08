<?php

use yii\db\Migration;

class m160815_071100_banners extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%banners}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'slug' => $this->string()->notNull(),
            'type' => "ENUM('home', 'category', 'product', 'other') NOT NULL DEFAULT 'other'",
            'status' => $this->smallInteger()->defaultValue(1),
        ], $tableOptions);

        $this->createIndex( 'banner_type', '{{%banners}}', 'type');
    }

    public function safeDown()
    {
        $this->dropTable('{{%banners}}');
    }
}
