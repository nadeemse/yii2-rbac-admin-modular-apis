<?php

namespace api\modules\settings\v1\controllers;

use api\core\controllers\BaseRestController;
use api\modules\settings\v1\models\Cities;

/**
 * Area controller that will use BaseRestController and default yii2 Rest APIS
 *  This controller is for user areas like area 1, area 2 etc.
 *
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
class AreasController extends BaseRestController
{
    public $modelClass = 'api\modules\settings\v1\models\Areas';

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
            //Assigning scopes and permissions regarding yii\rest\ActiveController core methods
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

    public function actions()
    {
        $actions = parent::actions();
        // disable the "delete" and "create" actions
        unset($actions['index']);

        return $actions;
    }

    /**
     * Action Index
     * */
    public function actionIndex() {

        $params = \Yii::$app->request->queryParams;

        $searchByAttr['Areas'] = $params;

        $searchModel = new $this->modelClass();

        if($params['city']) {
            $city = Cities::findOne(['name' => $params['city']]);
            if($city !== null) {
                $searchModel->city_id = $city->id;
            }
        }

        return $searchModel->search($searchByAttr);

    }
}


