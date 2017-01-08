<?php

namespace api\modules\user\v1\controllers;

use api\core\controllers\BaseRestController;
use common\models\Accounts;
use Yii;
use common\models\PasswordResetRequestForm;
use common\models\ResetPasswordForm;
use common\models\SignupForm;
use common\models\LoginForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use api\core\components\exception\RestException;

/**
 * Session Controller is used for user registration, login functionality, reset password
 *
 * */
class SessionController extends BaseRestController
{
    public $modelClass = 'common\models\Accounts';

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
                'actions' => ['create', 'reset-password', 'forgot-password', 'login', 'signup', 'facebook-login'],
                'roles'   => ['?'],
            ],
            [
                'allow'   => true,
                'actions' => ['options'],
                'roles'   => ['?'],
            ]
        ];
    }

    /**
     * Actions
     * */
    public function actions() {
        $actions = parent::actions();
        unset($actions['create']);
        return $actions;
    }

    /**
     * Create Action is mapped to Signup Function
     * @return mixed $auth_key if successfull login
     *
     * */
    public function actionCreate() {

        $inputs = Yii::$app->getRequest()->getBodyParams();

        $model = new SignupForm(['scenario' => 'self']);
        if ($model->load($inputs, '') && $model->validate()) {

            if ($user = $model->signup()) {

                if (Yii::$app->getUser()->login($user)) {
                    return ['auth_key' => Yii::$app->user->identity->getAuthKey()];

                }
            }
        }

        $model->validate();
        return $model;

    }

    /**
     * Social Login
     * This function will allow user to login with facebook
     * @return object $model
     * */
    public function actionFacebookLogin() {

        $inputs = Yii::$app->getRequest()->getBodyParams();
        $model = new SignupForm(['scenario' => 'facebook']);

        $model->load($inputs, '');

        // Check if user already exist then simply login
        $account = Accounts::find()->where(['socialType' => $model->scenario, 'socialID' => $model->socialID ])->one();

        //If user not exist then allow him to create and login
        if($account !== null) {
            return ['auth_key' => $account->auth_key];
        }

        if ($model->load($inputs, '') && $model->validate()) {

            if ($user = $model->signup()) {

                if (Yii::$app->getUser()->login($user)) {
                    return ['auth_key' => Yii::$app->user->identity->getAuthKey()];

                }
            }
        }

        $model->validate();
        return $model;

    }


    /**
     * Login into Application
     * @return string access_token for current customer
     * */
    public function actionLogin()
    {
        $model = new LoginForm();

        $inputs = Yii::$app->getRequest()->getBodyParams();

        if ($model->load($inputs, '') && $model->login()) {
            return ['auth_key' => Yii::$app->user->identity->getAuthKey()];
        } else {
            $model->validate();
            return $model;
        }
    }

    /**
     * Forgot password request
     * @return boolean true with message and false with exception
     * */
    public function actionForgotPassword() {

        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate()) {
            if ($model->sendEmail()) {
                return [
                    'message' => 'Check your email for further instructions',
                ];
            } else {
               return RestException::parametersNotValid('Sorry, we are unable to reset password for email provided');
            }
        }

        return $model;
    }

    /**
     * Reset password
     * @param $token reset password
     * @return object $model, customer
     * @throws BadRequestHttpException http exception
     * */
    public function actionResetPassword($password_token)
    {

        try {
            $model = new ResetPasswordForm($password_token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->getRequest()->getBodyParams(), '') && $model->validate() && $model->resetPassword()) {

            return ['message' => 'Your password has been updated successfully.'];
        }

        return $model;
    }

}
