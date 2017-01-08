<?php

use yii\db\Migration;

class m160926_193452_item_images extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%item_images}}', [
            'id' => $this->primaryKey(),
            'item_id' => $this->integer()->notNull(),
            'description' => $this->string(),
            'image' => $this->string(),
        ], $tableOptions);

        $this->createIndex('item', '{{%item_images}}', 'item_id');

        $this->addForeignKey('item_FK', '{{%item_images}}', 'item_id', 'items' , 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%item_images}}');
    }
}
