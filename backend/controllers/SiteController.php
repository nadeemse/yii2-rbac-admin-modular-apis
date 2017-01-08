<?php
namespace backend\controllers;

use app\models\Accounts;
use app\models\AccountSearch;
use app\models\itemsSearch;
use common\models\AdminLoginForm;
use common\models\User;
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new itemsSearch();
        $searchModel->status = 2;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $accountSearchModel = new AccountSearch();
        $accountSearchModel->status = 0;
        $accountDataProvider = $accountSearchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'accountDataProvider' => $accountDataProvider,
        ]);

    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        /*$users = User::find()->all();

        foreach($users as $user) {
            $user->setPassword('admin123');
            $user->save();
        }*/

        $this->layout = 'before_login';

        if (!Yii::$app->user->isGuest) {
            return $this->redirect(Yii::$app->user->getReturnUrl());
        }

        $model = new AdminLoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(['/']);
    }
}
