<?php

use yii\db\Migration;

class m160317_124440_create_new_table_oauth_users extends Migration
{
    public function up()
    {
        $tables = Yii::$app->db->schema->getTableNames();
        $dbType = $this->db->driverName;
        $tableOptions_mysql = "CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB";
        if (!in_array('oauth_users', $tables)) {
            if ($dbType == "mysql") {
                $this->createTable('{{%oauth_users}}', [
                    'id' => $this->primaryKey(),
                    'username' => $this->string(255),
                    'password_hash' => $this->string(255),
                    'first_name' => $this->string(255),
                    'last_name' => $this->string(255),
                    'type' => "ENUM('WEBSITE', 'MOBILE') NOT NULL DEFAULT 'WEBSITE'",
                    'status' => $this->smallInteger(6)->notNull()->defaultValue(1),
                    'created_at'   => $this->integer(),
                    'updated_at'    => $this->integer()
                ], $tableOptions_mysql);


                $this->batchInsert('{{%oauth_users}}', ['username', 'password_hash', 'first_name', 'status'], [
                    ['info@brrat.com', Yii::$app->security->generatePasswordHash('#brratweb91'), 'Info', 1]
                ]);
            }
        }
    }

    public function down()
    {
        $this->dropTable('{{%oauth_users}}');
    }
}

