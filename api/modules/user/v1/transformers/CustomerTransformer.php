<?php

namespace api\modules\user\v1\transformers;

use api\core\helpers\ArrayHelper;
use api\modules\user\v1\models\Customer;
use api\core\transformers\BaseTransformer;

class CustomerTransformer extends BaseTransformer
{
    /**
     *
     * Manipulates the routes array according to the business logic
     *
     * @param array $route routes array to be manipulated
     *
     * @return array manipulated routes array
     *
     * @author  * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public static function transform( $address )
    {
        if ($address instanceof Customer) {
            $routeData = $address->toArray();
        } else {
            $routeData = $address;
        }

        $routeData['customer_token'] = $routeData['customerkey'];

        unset($routeData['customerkey']);

        return $routeData;

    }
}
