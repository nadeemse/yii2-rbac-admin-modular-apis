<?php

namespace api\modules\settings\v1\controllers;

use api\core\controllers\BaseRestController;

/**
 * PageController API
 *
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
class PageController extends BaseRestController
{
    public $modelClass = 'api\modules\settings\v1\models\CmsPages';

    /**
     * Access Control function is used to handle application scope,
     * Either an application allowed to access a resources or not.
     * For example you have two different applicaiton one can access some resources and one can't so -
     * you can achieve that by simply defining
     * into access control.
     *
     * @return array
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     */
    public function accessControls()
    {
        return [
            [
                'allow' => true,
                'roles' => ['?'],
            ],

            [
                'allow'   => true,
                'actions' => ['options'],
                'roles'   => ['?'],
            ],
        ];
    }
}


