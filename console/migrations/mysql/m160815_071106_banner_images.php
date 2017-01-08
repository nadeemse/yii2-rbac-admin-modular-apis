<?php

use yii\db\Migration;

class m160815_071106_banner_images extends Migration
{
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%banner_images}}', [
            'id' => $this->primaryKey(),
            'banner_id' => $this->integer()->notNull(),
            'title' => $this->string(),
            'description' => $this->string(),
            'image' => $this->string()->notNull(),
            'link' => $this->string(),
            'sort_order' => $this->integer(),
            'status' => $this->smallInteger()->defaultValue(1),
        ], $tableOptions);

        $this->createIndex( 'banners', '{{%banner_images}}', 'banner_id');
        $this->addForeignKey( 'banners', '{{%banner_images}}', 'banner_id', '{{%banners}}', 'id', 'CASCADE', 'CASCADE');

    }

    public function safeDown()
    {
        $this->dropTable('{{%banner_images}}');
    }
}
