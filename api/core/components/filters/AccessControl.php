<?php

namespace api\core\components\filters;

class AccessControl extends \yii\filters\AccessRule
{
    /** @var array list of scopes, used for setting scope for controller */
    public $scopes = [];
}
