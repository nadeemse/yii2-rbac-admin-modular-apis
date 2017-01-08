<?php

namespace common\helpers;

use Yii;
use app\models\Settings;

/**
 * Country Model
 *
 * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
 */
class AppSetting
{

    public $settings;

    public function __construct() {
        $this->settings = Settings::find()->one();
    }

    public function getSettings() {
        return $this->settings;
    }

    public function getByAttribute($attribute) {
        return $this->settings->{$attribute};
    }
}
