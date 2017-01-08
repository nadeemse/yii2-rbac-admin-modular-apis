<?php

namespace api\modules\user\v1\controllers;

use api\modules\catalog\v1\models\Items;
use api\modules\user\v1\models\Accounts;
use Yii;
use api\core\controllers\BaseRestController;
use yii\helpers\ArrayHelper;
use yii\web\UnauthorizedHttpException;

/**
 * Account Controller
 */
class AccountController extends BaseRestController
{
    public $modelClass = 'api\modules\user\v1\models\Accounts';

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
                'actions' => ['view', 'profile', 'my-items', 'update'],
                'roles'   => ['@'],
                'scopes'  => ['account', 'profile', 'required-customer-token'],
            ],

            [
                'allow'   => true,
                'actions' => ['options', 'verify'],
                'roles'   => ['?'],
            ]
        ];
    }

    /**
     * Override default actions
     * */
    public function actions() {

        $actions = parent::actions();
        unset($actions['view'], $actions['update']);

        return $actions;

    }

    /**
     * View Profile function
     * @return object $profile
     *
     * */
    public function actionView() {
        return $this->findModel();
    }

    /**
     * View Profile function
     * @return object $profile
     *
     * */
    public function actionUpdate() {

        $model = $this->findModel();

        $inputs = Yii::$app->getRequest()->getBodyParams();

        if($model->load($inputs, '') && $model->validate()) {
            $model->save();
            return $model;
        } else {
            return $model;
        }
    }

    /**
     * View Profile function
     * @return object $profile
     *
     * */
    public function actionVerify($code) {

        $model = Accounts::find()->where(['verification_code' => $code])->one();

       if( $model !== null ) {
           $model->status = 1;

           $model->verification_code = null;
           $model->save(false);
           return ['message' => 'Account has been verified.'];
       } else {
           throw new UnauthorizedHttpException('Verification code has been expired or invalid.');
       }
    }

    /**
     * My Products
     * */
    public function actionMyItems() {

        $getParams = \Yii::$app->request->queryParams;
        $postParams = Yii::$app->getRequest()->getBodyParams();

        foreach($postParams as $key => $value) {
            if(empty($value) || $value === 'null') {
                unset($postParams[$key]);
            }
        }
        $params = ArrayHelper::merge($getParams, $postParams);

        $searchByAttr['Items'] = $params;
        $searchModel = new Items();

        // Get Current Account
        $account = $this->getCustomer();

        $searchModel->seller_id = $account->id;

        $searchModel->status = [1, 2, 3]; // Active, In-active, Pending approval Items
        return $searchModel->search($searchByAttr);

    }

    /**
     * find model with customer token
     * */
    public function findModel() {


        $customer = $this->getCustomer();
        $model =  (new $this->modelClass())->find()->with('country')->where(['id' => $customer->id])->one();

        if($model !== null) {
            return $model;
        } else {
            throw new UnauthorizedHttpException('You are not allowed to perform this action.');
        }

    }
}
