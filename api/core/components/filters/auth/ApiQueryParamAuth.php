<?php

namespace api\core\components\filters\auth;

use yii\filters\auth\QueryParamAuth;

class ApiQueryParamAuth extends QueryParamAuth
{
    /**
     * @inheritdoc
     */
    public function authenticate($user, $request, $response)
    {
        return parent::authenticate($user, $request, $response);
    }
}
