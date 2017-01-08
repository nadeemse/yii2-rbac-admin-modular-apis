<?php

namespace api\modules\information\v1\controllers;

use api\core\components\exception\RestException;
use api\core\controllers\BaseRestController;

/**
 * Page controller that will use BaseRestController and default yii2 Rest APIS
 *  This controller is for static pages like terms & conditions, About us etc.
 *  Default function of this controller is actionIndex and that we are using from core yii2 restController
 *  actionIndex will return all listed pages
 *
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
class PageController extends BaseRestController
{
    public $modelClass = 'api\modules\information\v1\models\CmsPages';

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

    /**
     * Actions function
     * */
    public function actions() {
        $actions = parent::actions();
        unset($actions['view']);
        return $actions;
    }

    /**
     * View by slug
     * @param string $slug
     * @return object $model of slug based data
     * */
    public function actionView($slug) {

        $model =  (new $this->modelClass())->find()->where(['seo_url' => $slug])->one();

        if($model !== null) {
            return $model;
        } else {
            return RestException::dataValidationFailed(422, 'Data not found with given page.', 422);
        }
    }
}


