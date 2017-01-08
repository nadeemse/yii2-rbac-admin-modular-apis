<?php

namespace api\core\components\filters;

use Yii;
use yii\filters\auth\HttpBearerAuth;
use yii\web\ForbiddenHttpException;
use api\core\components\filters\auth\ApiQueryParamAuth;
/**
 * Filter for analyze controller's access rules and determine public actions and scopes
 * for private actions. If action is private than check oauth access token and if it has needed
 * scopes to this action
 */
class OAuth2AccessControl extends \yii\base\ActionFilter
{
    /**
     * DESC
     *
     * @param \yii\base\Action $action request action
     *
     * @return boolean
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\ForbiddenHttpException
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     */
    public function beforeAction($action)
    {
        $actionName = $action->id;

        list($publicActions, $actionsScopes) = $this->analyzeAccessControls($actionName);

        if (in_array($actionName, $publicActions)) {
            // action is public
            return true;
        }

        // else, if not public, add additional auth filters
        if (Yii::$app->hasModule('oauth2')) {
            /** @var \filsh\yii2\oauth2server\Module $oauthModule */
            $oauthModule = Yii::$app->getModule('oauth2');

            // Query Param Auth
            $queryParamAuth = ['class' => ApiQueryParamAuth::className()];

            // set access token param name
            if (!empty($oauthModule->tokenParamName)) {
                $queryParamAuth['tokenParam'] = $oauthModule->tokenParamName;
            }

            // This part will need to move into Main Controller
            // set behaviours
            $authBehavior = $this->owner->getBehavior('authenticator');

            $authBehavior->authMethods = [
                $queryParamAuth,
                ['class' => HttpBearerAuth::className()]
            ];

            $scopes = isset($actionsScopes[$actionName]) ? $actionsScopes[$actionName] : '';
            if (is_array($scopes)) {
                $scopes = implode(' ', $scopes);
            }

            $oauthServer = $oauthModule->getServer();
            $oauthRequest = $oauthModule->getRequest();
            $oauthResponse = $oauthModule->getResponse();

            if (!$oauthServer->verifyResourceRequest($oauthRequest, $oauthResponse, $scopes)) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }

            // Check if there is scope name required-customer-profile then find customer based on token
            $hasTokenInScope = strpos($scopes, 'required-customer-token'); // this is controller scope to check if token is required or no
            $hasCustomerToken = Yii::$app->request->headers['customer-token'];
            if($hasTokenInScope && !$hasCustomerToken) {
                throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
            }

        }

        return parent::beforeAction($action);
    }

    /**
     * Get Public action and private actions with its scopes
     *
     * @param string $currentAction current request action method
     *
     * @return array
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     */
    protected function analyzeAccessControls($currentAction)
    {
        $accessControls = $this->owner->accessControls();

        $publicActions = [];
        $actionsScopes = [];
        $isMetCurrAction = false;

        foreach ($accessControls as $rule) {
            if (empty($rule['controllers']) || in_array($this->owner->uniqueId, $rule['controllers'], true)) {
                if (empty($rule['actions'])) {
                    $rule['actions'] = [$currentAction];
                }

                if (!empty($rule['actions']) && is_array($rule['actions']) && in_array($currentAction, $rule['actions'], true)) {
                    $isMetCurrAction = true;
                    $actions = $rule['actions'];
                    $is_public = null;

                    if (isset($rule['allow'])) {
                        if ($rule['allow'] && (empty($rule['roles']) || in_array('?', $rule['roles']))) {
                            $publicActions = array_merge($publicActions, $rule['actions']);
                            $is_public = true;
                        } else if ((!$rule['allow'] && (empty($rule['roles']) || in_array('?', $rule['roles'])))
                            || ($rule['allow'] && !empty($rule['roles']) && in_array('@', $rule['roles']))
                        ) {
                            $publicActions = array_diff($publicActions, $rule['actions']);
                            $is_public = false;
                        }
                    }

                    if ($is_public === false && !empty($rule['scopes'])) {
                        $ruleScopes = $rule['scopes'];
                        $scopes = is_array($ruleScopes) ? $ruleScopes : explode(' ', trim($ruleScopes));

                        foreach ($actions as $a) {
                            if (!isset($actionsScopes[$a])) {
                                $actionsScopes[$a] = $scopes;
                            } else {
                                $actionsScopes[$a] = array_merge($actionsScopes[$a], $scopes);
                            }
                        }
                    }
                }
            }
        }
        if (!$isMetCurrAction) {
            $publicActions[] = $currentAction;
        }

        return [$publicActions, $actionsScopes];
    }
}
