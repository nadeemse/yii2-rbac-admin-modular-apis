<?php

namespace api\core\controllers;

use api\core\components\traits\controllers;
/**
 * APIController class
 * */
class ApiController extends \yii\rest\ActiveController
{
    use controllers\OAuthTrait;
    use controllers\SearchTrait;
}
