<?php

use yii\db\Migration;

class m161004_021459_accounts extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }


        $this->createTable('{{%accounts}}', [
            'id' => $this->primaryKey(),
            'email' => $this->string()->notNull()->unique(),
            'auth_key' => $this->string(64)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'password_reset_token' => $this->string()->unique(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'amazing_offers' => $this->smallInteger()->notNull()->defaultValue(0),
            'occasional_updates' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
        ], $tableOptions);

        $this->batchInsert('{{%accounts}}', ['email', 'password_hash', 'status', 'auth_key', 'password_reset_token'], [
            ['info@yii2admin.com', Yii::$app->security->generatePasswordHash('yii2Admin'), 1, yii::$app->security->generateRandomString(), yii::$app->security->generateRandomString() . '_' . time()]
        ]);

    }

    public function down()
    {
        $this->dropTable('{{%accounts}}');
    }

}
