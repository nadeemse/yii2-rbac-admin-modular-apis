<?php

namespace api\modules\user\v1\transformers;

use api\core\helpers\ArrayHelper;
use api\modules\user\v1\models\Address;
use api\core\transformers\BaseTransformer;

class AddressTransformer extends BaseTransformer
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
        if ($address instanceof Address) {
            $transformedData = $address->toArray();

            if($address->hasArea) {
                $transformedData['area'] = ArrayHelper::toArray($address->hasArea);
                $transformedData['area']['branch'] = ArrayHelper::toArray($address->hasArea->branch);
            }

            return $transformedData;

        } else {
            $routeData = $address;
        }

        $transformedData  = [];

        unset($routeData[Address::primaryKey()[0]]);
        foreach($routeData as $key => $data) {
            $transformedData[$key] = $data->toArray();

            if($data->hasArea) {
                $transformedData[$key]['area'] = ArrayHelper::toArray($data->hasArea);
                $transformedData[$key]['area']['branch'] = ArrayHelper::toArray($data->hasArea->branch);
            }
        }

        return $transformedData;

    }
}
