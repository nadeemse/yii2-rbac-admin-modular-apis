<?php

use yii\db\Migration;

class m161023_193944_social_id_and_social_type_in_accounts extends Migration
{
    public function up()
    {
        $this->addColumn('{{%accounts}}', 'socialType', "ENUM('self', 'facebook') NOT NULL DEFAULT 'self'");
        $this->addColumn('{{%accounts}}', 'socialID', $this->string());
    }

    public function down()
    {
        $this->dropColumn('{{%accounts}}', 'socialType');
        $this->dropColumn('{{%accounts}}', 'socialID');
    }
}
