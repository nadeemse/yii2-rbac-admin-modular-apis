<?php

use yii\db\Migration;

class m161115_173634_oauth_users extends Migration
{
    public function up()
    {

        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";

        $this->dropTable('{{%oauth_users}}');

        $this->createTable('{{%oauth_users}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string(255),
            'password_hash' => $this->string(255),
            'first_name' => $this->string(255),
            'last_name' => $this->string(255),
            'type' => "ENUM('web', 'ios', 'android', 'thirdParty') NOT NULL DEFAULT 'web'",
            'status' => $this->smallInteger(6)->notNull()->defaultValue(1),
            'created_at'   => $this->integer(),
            'updated_at'    => $this->integer()
        ], $tableOptions_mysql);

        $this->batchInsert('{{%oauth_users}}', ['username', 'password_hash', 'first_name', 'status'], [
            ['api@nadeemakhtar.info', Yii::$app->security->generatePasswordHash('#api'), 'api', 1]
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%oauth_users}}');
    }
}
