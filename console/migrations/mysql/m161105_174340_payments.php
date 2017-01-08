<?php

use yii\db\Migration;

class m161105_174340_payments extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%payments}}', [
            'id'                    => $this->primaryKey(),
            'account_id'            => $this->integer()->notNull(),
            'description'           => $this->string(255)->notNull(),
            'payment_gateway'       => "ENUM('PayPal','2CheckOut','PayFort', 'Checkout.com') NOT NULL DEFAULT 'PayPal'",
            'amount'                => $this->double()->notNull()->defaultValue(0),
            'payment_reference_id'  => $this->string(),
            'package_id'            => $this->integer()->notNull(),
            'created_at'            => $this->integer(),
            'updated_at'            => $this->integer(),
            'expire_on'            => $this->integer(),
            'status'                => $this->string(),
        ], $tableOptions);

        $this->createIndex('account_index', '{{%payments}}', 'account_id');
        $this->addForeignKey('account_FK', '{{%payments}}', 'account_id', 'accounts', 'id', 'CASCADE', 'CASCADE');

    }

    public function down()
    {
        $this->dropTable('{{%payments}}');
    }

}
