<?php

use yii\db\Migration;

class m160815_071049_cms_pages extends Migration
{
    /* @up
     * @migration that will create a new table static_pages
     * @attributes {id, title, description, meta_title, meta_description, meta_keywords, seo_keywords, bottom, top, status, sort_order, seo_url}
     * @engine is InnoDB
     * */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->createTable('{{%cms_pages}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull()->unique(),
            'seo_url' => $this->string()->notNull()->unique(),
            'description' => $this->text()->notNull(),
            'meta_title' => $this->string(150),
            'meta_description' => $this->string(150),
            'meta_keywords' => $this->string(150),
            'seo_keywords' => $this->string(100),
            'bottom' => $this->smallInteger()->notNull()->defaultValue(0),
            'top' => $this->smallInteger()->notNull()->defaultValue(0),
            'sort_order' => $this->smallInteger()->defaultValue(0),
            'banner_image' => $this->string(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
        ], $tableOptions);

        $this->createIndex('url', '{{%cms_pages}}', 'seo_url');

    }

    /* @down
     * @Down the table static_pages
     * */

    public function safeDown()
    {
        $this->dropTable('{{%cms_pages}}');
    }
}
