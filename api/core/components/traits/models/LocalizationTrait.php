<?php

namespace core\components\traits\models;

use Yii;

trait LocalizationTrait
{
    /**
     * validate localized field
     * validate that locale codes are valid locale codes
     * validate that the translation for the default app language exists
     *
     * @param string $attribute       model translatable attribute
     * @param array  $translationsArr translations array
     *
     * @return void
     *
     * @author Nadeem Akhtar <nadeemakhtar.se@gmail.com>
     *
     */
    public function validateLocalization($attribute, $translationsArr)
    {
        $localeArr = array_column($translationsArr, 'locale');

        //validate that the locale codes are in the right format, like "ar-EG"
        array_walk($localeArr, function ($locale, $key, $attribute) {
            if (!preg_match('/^[a-z]{2}-[A-Z]{2}$/i', $locale)) {
                $this->addError($attribute, $locale . ' is not a valid locale code (valid code like: en-US)');
            }
        }, $attribute);

        //validate that default locale translation Yii::$app->language exists
        if (!in_array(Yii::$app->language, array_column($translationsArr, 'locale'))) {
            $this->addError($attribute, 'localization for the default locale must be set(' . Yii::$app->language . ')');
        }
    }
}
