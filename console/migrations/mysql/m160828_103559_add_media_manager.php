<?php

use yii\db\Migration;

class m160828_103559_add_media_manager extends Migration
{
    /**
     * Up function will add migraiton into database table
     * @return boolean true or false
     * */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%media_manager}}', [
            'id'            => $this->primaryKey(),
            'type'          => "ENUM('folder', 'file') NOT NULL DEFAULT 'file'",
            'name'          => $this->string()->notNull(),
            'href'          => $this->string(),
            'parent_id'     => $this->integer()->defaultValue(0),
            'created_at'    => $this->dateTime(),
        ], $tableOptions);

        $this->createIndex('media_name', '{{%media_manager}}', 'name');
    }

    /**
     * Down function will add migraiton into database table
     * @return boolean true or false
     * */
    public function safeDown()
    {
        $this->dropTable('{{%media_manager}}');
    }
}
