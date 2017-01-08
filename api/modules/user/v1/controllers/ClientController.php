<?php

namespace api\modules\user\v1\controllers;

use api\core\models\OauthClients;
use \yii\rest\ActiveController;
use Yii;

class ClientController extends ActiveController
{

    public $modelClass = '\api\core\models\OauthClients';

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
                'actions' => ['options', 'index'],
                'roles'   => ['?'],
            ],
        ];
    }
}
