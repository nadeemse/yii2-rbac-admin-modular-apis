<?php
namespace api\core\components\rest;

use yii\rest\UrlRule;
use Yii;

class RestUrlRule extends UrlRule
{
    public $pluralize = false;

    /**
     * Override init function
     *
     * @return void
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function init()
    {
        $this->tokens = [
            '{id}' => '<id:[\w]+>',
        ];

        parent::init();
    }
}
