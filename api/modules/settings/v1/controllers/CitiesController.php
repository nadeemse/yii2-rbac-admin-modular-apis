<?php

namespace api\modules\settings\v1\controllers;

use api\core\controllers\BaseRestController;

/**
 * cities controller that will use BaseRestController and default yii2 Rest APIS
 *  This controller is for user areas like berlin.
 *
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
class CitiesController extends BaseRestController
{
    public $modelClass = 'api\modules\settings\v1\models\Cities';

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


