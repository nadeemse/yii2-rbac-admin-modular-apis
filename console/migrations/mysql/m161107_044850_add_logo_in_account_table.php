<?php

use yii\db\Migration;

class m161107_044850_add_logo_in_account_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%accounts}}', 'picture', 'VARCHAR(255) DEFAULT NULL');

    }

    public function down()
    {
        $this->dropColumn('{{%accounts}}', 'picture');
    }
}
