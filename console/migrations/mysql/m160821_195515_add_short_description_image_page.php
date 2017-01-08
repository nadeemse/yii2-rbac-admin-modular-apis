<?php

use yii\db\Migration;

class m160821_195515_add_short_description_image_page extends Migration
{
    /**
     * @inheritdoc
     * @return boolean return a false value to indicate the migration fails
     */
    public function safeUp()
    {
        $this->addColumn('{{%cms_pages}}', 'short_description', ' VARCHAR(255) AFTER `id` ');
    }

    /**
     * @inheritdoc
     * @return boolean return a false value to indicate the migration fails
     */
    public function safeDown()
    {
        $this->dropColumn('{{%cms_pages}}', 'short_description');
    }
}
