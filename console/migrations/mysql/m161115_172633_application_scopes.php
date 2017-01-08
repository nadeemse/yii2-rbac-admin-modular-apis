<?php

use yii\db\Migration;

class m161115_172633_application_scopes extends Migration
{
    public function up()
    {
        $this->batchInsert('{{%oauth_scopes}}', ['scope', 'is_default'], [
            ['root', 1],
            ['account', 0],
            ['profile', 0],
            ['required-customer-token', 0],
            ['catalog', 0],
            ['scope', 0],
            ['user', 0],
            ['editor', 0],
            ['admin', 0],

        ]);

    }

    public function down()
    {
        return true;
    }
}
