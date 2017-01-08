<?php

use yii\db\Migration;

class m161004_022401_create_country extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%country}}', [
            'id' => $this->primaryKey(),
            'country_code' => $this->string()->notNull(),
            'country_name' => $this->string()->notNull()
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%country}}');
    }
}
