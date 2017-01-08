<?php

use yii\db\Migration;

class m161107_062549_add_phone_number_in_profile extends Migration
{
    public function up()
    {
        $this->addColumn('{{%accounts}}', 'phone_number', 'VARCHAR(255) DEFAULT NULL');

    }

    public function down()
    {
        $this->dropColumn('{{%accounts}}', 'phone_number');
    }
}
