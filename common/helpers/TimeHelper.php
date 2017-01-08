<?php

namespace common\helpers;

use Yii;

/**
 * Country Model
 *
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
class TimeHelper
{

    /**
     * @return string
     */
    public static function getTime()
    {
        $time = new \DateTime('now');
        return $time->format('Y-m-d H:i:s');
    }

    /**
     * @return string
     */
    public function readAbleFormat($date) {
        return date("F jS, Y",strtotime($date));
    }
}
