<?php

use yii\db\Migration;

class m161014_111726_add_account_attribute_name extends Migration
{
    public function up()
    {
        $this->addColumn('{{%accounts}}', 'first_name', $this->string()->notNull() );
        $this->addColumn('{{%accounts}}', 'last_name', $this->string() );
        $this->addColumn('{{%accounts}}', 'dob', $this->date() );
        $this->addColumn('{{%accounts}}', 'gender', $this->smallInteger() );
        $this->addColumn('{{%accounts}}', 'country', $this->integer() );
    }

    public function down()
    {
        $this->dropColumn('{{%accounts}}', 'first_name' );
        $this->dropColumn('{{%accounts}}', 'last_name' );
        $this->dropColumn('{{%accounts}}', 'dob' );
        $this->dropColumn('{{%accounts}}', 'gender' );
        $this->dropColumn('{{%accounts}}', 'country' );
    }
}
