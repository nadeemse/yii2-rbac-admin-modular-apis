<?php

use yii\db\Migration;

class m160926_193444_items extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%items}}', [
            'id' => $this->primaryKey(),
            'name' => $this->integer()->notNull(),
            'price' => $this->string()->notNull(),
            'seller_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'age_id' => $this->integer()->notNull(),
            'usage_id' => $this->integer()->notNull(),
            'condition_id' => $this->integer()->notNull(),
            'description' => $this->text(),
            'image' => $this->string(),
            'status' => $this->integer()->defaultValue(1),
            'created_at' => $this->dateTime(),
            'updated_at' => $this->dateTime(),
        ], $tableOptions);

        $this->createIndex('category', '{{%items}}', 'category_id');

        $this->addForeignKey('category_FK', '{{%items}}', 'category_id', 'categories' , 'id', 'CASCADE', 'CASCADE');
    }

    public function down()
    {
        $this->dropTable('{{%items}}');
    }
}
