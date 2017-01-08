<?php

use yii\db\Migration;

class m161028_110934_area_table_edit extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%areas}}', 'area_code', 'VARCHAR(20)');

    }

    public function down()
    {
        $this->alterColumn('{{%areas}}', 'area_code', 'INT(11)');
    }
}
