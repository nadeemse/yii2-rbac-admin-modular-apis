<?php

use yii\db\Migration;

class m160815_071025_setting_module extends Migration
{
    public function up()
    {
        $tableOptions = null;

        if ($this->db->driverName === 'mysql')
        {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%settings}}', [
            'id' => $this->primaryKey(),
            'app_name' => $this->string()->notNull(),
            'app_owner' => $this->string(),
            'admin_email' => $this->string()->notNull(),
            'from_email' => $this->string()->notNull(),
            'address' => $this->string(),
            'app_logo' => $this->string()->notNull(),
            'footer_logo' => $this->string(),
            'currency' => $this->string(),
            'location' => $this->string(),
            'Geocode' => $this->string(),
            'telephone' => $this->string(),

            'copyright_text' => $this->string(),
            'about' => $this->text(),

            'meta_title' => $this->string()->notNull(),
            'meta_tag' => $this->string(),
            'meta_tag_description' => $this->string(),

            'smtp_email' => $this->string(),
            'smtp_username' => $this->string(),
            'smtp_password' => $this->string(),
            'smtp_hash' => " ENUM('ssl', 'tls') DEFAULT 'ssl'",
            'smtp_port' => $this->integer(),
        ], $tableOptions);

    }

    public function down()
    {
        $this->dropTable('{{%settings}}');
    }
}
