<?php

use yii\db\Migration;

class m161030_055741_add_verification_code_in_accounts extends Migration
{
    public function up()
    {
        $this->addColumn('{{%accounts}}', 'verification_code', 'VARCHAR(255) DEFAULT NULL');

    }

    public function down()
    {
        $this->dropColumn('{{%accounts}}', 'verification_code');
    }
}
