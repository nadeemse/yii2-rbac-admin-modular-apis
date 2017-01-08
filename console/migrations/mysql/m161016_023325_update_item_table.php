<?php

use yii\db\Migration;

class m161016_023325_update_item_table extends Migration
{
    public function up()
    {
        $this->alterColumn('{{%items}}', 'name', $this->string()->notNull() );
        $this->addColumn('{{%items}}', 'seo_url', $this->string() );
        $this->addColumn('{{%items}}', 'meta_title', $this->string() );
        $this->addColumn('{{%items}}', 'meta_keywords', $this->string() );
        $this->addColumn('{{%items}}', 'meta_description', $this->string() );
    }

    public function down()
    {
        $this->alterColumn('{{%accounts}}', 'name', $this->integer()->notNull() );
        $this->dropColumn('{{%accounts}}', 'seo_url' );
        $this->dropColumn('{{%accounts}}', 'meta_title' );
        $this->dropColumn('{{%accounts}}', 'meta_keywords' );
        $this->dropColumn('{{%accounts}}', 'meta_description' );
    }

}
