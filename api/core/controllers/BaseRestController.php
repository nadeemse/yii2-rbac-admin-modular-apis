<?php

namespace api\core\controllers;

use common\models\Accounts;
use Yii;
/**
 * Base rest controller to define some settings at top level
 * */
class BaseRestController extends ApiController
{
    // Define Cache & init Parent
    public function init()
    {
        parent::init();
    }

    /**
     * @var null
     */
    public $modelClass = null;

    /**
     * @var string
     */
    public $serializer = 'api\core\components\web\RestSerializer';

    /**
     * Enable Rate Limiter
     *
     * @return array
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['rateLimiter']['enableRateLimitHeaders'] = true;
        $behaviors['corsFilter'] = [
            'class' => \yii\filters\Cors::className(),
            'cors' => [
                'Origin' => ['*'],
                'Access-Control-Request-Method' => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'HEAD', 'OPTIONS'],
                'Access-Control-Request-Headers' => ['*'],
                'Access-Control-Expose-Headers' => [
                    'X-Pagination-Total-Count',
                    'X-Pagination-Page-Count',
                    'X-Pagination-Current-Page',
                    'X-Pagination-Per-Page'
                ],
                'Access-Control-Allow-Credentials' => true,
                'Access-Control-Max-Age' => 86400,
            ],
        ];

        return $behaviors;
    }

    /**
     * Get Request Object
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getRequest()
    {
        return \Yii::$app->getRequest();
    }

    /**
     * Get Response Object
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function getResponse()
    {
        return \Yii::$app->getResponse();
    }

    /**
     * Convert query from string, json, serialized array to Array ( most used in get requests to accept multiple ways
     * of input )
     *
     * @param string $queryString query from GET
     *
     * @return array|mixed
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public static function queryParamToArray($queryString)
    {
        if (!isset($queryString)) {
            return $queryString;
        }

        $query = static::decodeParams($queryString);

        $codes = json_decode($query, true);

        // json_decode int return int so check for in_array
        if (!$codes || !is_array($codes)) {
            $codes = @unserialize($query);
        }
        // not json, not serialized array then put it in array
        if (!$codes) {
            $codes = [$query];
        }

        if (!$codes) {
            return [];
        }

        return $codes;
    }

    /**
     * decode url params just alias for urldecode for now
     *
     * @param string $params url params
     *
     * @return string encoded url
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public static function decodeParams($params)
    {
        return urldecode($params);
    }

    /**
     * Get Customer by header token
     * */
    public function getCustomer()
    {

        $customerToken = Yii::$app->request->headers['customer-token'];
        $customer = Accounts::findIdentityByAccessToken($customerToken);

        if ($customer !== null) {
            return $customer;
        } else {
            throw new ForbiddenHttpException(Yii::t('yii', 'You are not allowed to perform this action.'));
        }
    }
}
