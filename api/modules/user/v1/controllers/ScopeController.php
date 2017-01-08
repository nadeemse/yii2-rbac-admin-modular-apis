<?php
namespace user\v1\controllers;

use api\core\controllers\BaseRestController;
use Yii;

class ScopeController extends BaseRestController
{

    public $modelClass = '\filsh\yii2\oauth2server\models\OauthScopes';

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
                'allow'   => true,
                'actions' => ['view', 'index'],
                'roles'   => ['@'],
                'scopes'  => ['scope', 'user'],
            ],
            [
                'allow'   => true,
                'actions' => ['create', 'update'],
                'roles'   => ['@'],
                'scopes'  => ['scope', 'editor'],
            ],
            [
                'allow'   => true,
                'actions' => ['delete'],
                'roles'   => ['@'],
                'scopes'  => ['scope', 'admin'],
            ],
            [
                'allow'   => true,
                'actions' => ['options'],
                'roles'   => ['?'],
            ],
        ];
    }
}
