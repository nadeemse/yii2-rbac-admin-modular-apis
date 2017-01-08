<?php
/**
 * Trait that contains needed behaviors for protect controller by OAuth2
 */

namespace api\core\components\traits\controllers;

use Yii;
use api\core\components\filters\OAuth2AccessControl;
use filsh\yii2\oauth2server\filters\ErrorToExceptionFilter;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;

trait OAuthTrait
{

    /**
     * DESC
     *
     * @return array
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        // replace to top contentNegotiator filter for displaying errors in correct format
        $content_negotiator = $behaviors['contentNegotiator'];
        unset($behaviors['contentNegotiator']);
        $content_negotiator['formats'] = Yii::$app->params['formats'];
        // IMPORTANT THE ORDER OR ARRAY MERGE !!!!!
        $behaviors =
            ArrayHelper::merge(
                [
                    'contentNegotiator' => $content_negotiator,
                    'oauth2access' => [ // should be before "authenticator" filter
                        'class' => OAuth2AccessControl::className(),
                    ],
                    'exceptionFilter' => [
                        'class' => ErrorToExceptionFilter::className(),
                    ],
                ],
                $behaviors,
                [
                    'access' => [ // need to set after contentNegotiator filter for caching errors
                        'class' => AccessControl::className(),
                        'rules' => $this->accessControls(),
                        'ruleConfig' => ['class' => 'api\core\components\filters\AccessControl'],
                    ],
                ]
            );

        return $behaviors;
    }

    /**
     * Access rules for access behavior
     *
     * @return array
     */
    public function accessControls()
    {
        return [];
    }

    /**
     * @return \yii\web\User
     */
    public function getUser()
    {
        return Yii::$app->getUser();
    }
}
