<?php

namespace api\modules\catalog\v1\controllers;

use api\core\controllers\BaseRestController;

use Yii;
use yii\web\NotFoundHttpException;
use api\modules\catalog\v1\models\Items;
use api\core\helpers\ArrayHelper;

/**
 * Item controller that will use BaseRestController and default yii2 Rest APIS
 *  This controller is used to get all items that are available.
 *
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
class ItemController extends BaseRestController
{
    public $modelClass = 'api\modules\catalog\v1\models\Items';

    /**
     * Access Control function is used to handle application scope,
     * Either an application allowed to access a resources or not.
     * For example you have two different applicaiton one can access some resources and one can't so -
     * you can achieve that by simply defining
     * into access control.
     *
     * Example
     *
     * ~~~
     *  [
     *       'allow'   => true,
     *       'actions' => ['create', 'update'],
     *       'roles'   => ['@'],
     *       'scopes'  => ['account', 'profile', 'required-customer-token'],
     *   ],
     * ~~~
     * Above Example showing that create and update action only allowed if APP token has scope of "account", "profile", "required-customer-token"
     *
     * @return array
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     */
    public function accessControls()
    {
        return [
            [
                'allow'   => true,
                'actions' => ['create', 'update'],
                'roles'   => ['@'],
                'scopes'  => ['account', 'profile', 'required-customer-token'],
            ],

            [
                'allow' => true,
                'actions' => ['view-by-slug', 'view', 'item-list'],
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
     * Actions
     * */
    public function actions() {
        $actions = parent::actions();
        unset($actions['view'], $actions['create'],$actions['update']);
        return $actions;
    }

    /**
     * Item list function
     * */
    public function actionItemList() {

        $getParams = \Yii::$app->request->queryParams;
        $postParams = Yii::$app->getRequest()->getBodyParams();

        foreach($postParams as $key => $value) {
            if(empty($value) || $value === 'null') {
                unset($postParams[$key]);
            }
        }

        $params = ArrayHelper::merge($getParams, $postParams);

        $searchByAttr['Items'] = $params;
        $searchModel = new $this->modelClass();

        $searchModel->status = 1;

        return $searchModel->search($searchByAttr);
    }

    /**
     * Displays a single Items model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->findModel('id', $id);
    }

    /**
     * Displays a single Items model.
     * @param integer $id
     * @return mixed
     */
    public function actionViewBySlug($slug)
    {
        $model = $this->findModel('seo_url', $slug);

        return $model;
    }

    /**
     * Creates a new Items model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Items();
        $customer = $this->getCustomer();

        $model->seller_id = $customer->id;

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save()) {
            return $model;
        } else {
            return $model;
        }
    }

    /**
     * Updates an existing Items model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel('id', $id);

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->save(false)) {
            return $model;
        } else {
            return $model;
        }
    }

    /**
     * Deletes an existing Items model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel('id', $id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Items model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Items the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($attribute, $value)
    {
        if (($model = Items::find()->where([$attribute => $value])->one()) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
