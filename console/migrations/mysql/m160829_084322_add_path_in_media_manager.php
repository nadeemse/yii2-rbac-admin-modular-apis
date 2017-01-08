<?php

use yii\db\Migration;

class m160829_084322_add_path_in_media_manager extends Migration
{
    /**
     * Up function will add migraiton into database table
     * @return boolean true or false
     * */
    public function up()
    {
        $this->addColumn('{{%media_manager}}', 'path', "VARCHAR(255)");
    }

    /**
     * Down function will add migraiton into database table
     * @return boolean true or false
     * */
    public function down()
    {
        $this->dropColumn('{{%media_manager}}', 'path');
    }
}
