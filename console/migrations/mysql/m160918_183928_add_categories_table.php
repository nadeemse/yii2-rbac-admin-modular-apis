<?php

use yii\db\Migration;

class m160918_183928_add_categories_table extends Migration
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

        $this->createTable('{{%categories}}', [
            'id'                => $this->primaryKey(),
            'name'              => $this->string()->notNull(),
            'slug'              => $this->string()->notNull()->unique(),
            'href'              => $this->string(),
            'banner'              => $this->string(),
            'description'       => $this->text(),
            'meta_description'  => $this->string(255),
            'meta_keywords'     => $this->string(255),
            'parent_id'         => $this->integer()->defaultValue(0),
            'status'            => $this->smallInteger()->defaultValue(0),
        ], $tableOptions);

        $this->createIndex('media_name', '{{%categories}}', 'name');
    }

    /**
     * Down function will add migraiton into database table
     * @return boolean true or false
     * */
    public function safeDown()
    {
        $this->dropTable('{{%categories}}');
    }

}
