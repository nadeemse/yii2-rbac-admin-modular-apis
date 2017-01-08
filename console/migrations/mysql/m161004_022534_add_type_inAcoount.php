<?php

use yii\db\Migration;

class m161004_022534_add_type_inAcoount extends Migration
{
    public function up()
    {
        $this->addColumn('{{%accounts}}', 'account_type', "ENUM('seller', 'customer') DEFAULT 'customer'");
    }

    public function down()
    {
        $this->dropColumn('{{%accounts}}', 'account_type');
    }

}
