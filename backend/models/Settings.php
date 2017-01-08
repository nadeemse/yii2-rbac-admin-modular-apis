<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "settings".
 *
 * @property integer $id
 * @property string $app_name
 * @property string $app_owner
 * @property string $admin_email
 * @property string $from_email
 * @property string $address
 * @property string $app_logo
 * @property string $footer_logo
 * @property string $currency
 * @property string $location
 * @property string $Geocode
 * @property string $telephone
 * @property string $copyright_text
 * @property string $about
 * @property string $meta_title
 * @property string $meta_tag
 * @property string $meta_tag_description
 * @property string $smtp_email
 * @property string $smtp_username
 * @property string $smtp_password
 * @property string $smtp_hash
 * @property integer $smtp_port
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['app_name', 'admin_email', 'from_email', 'app_logo', 'meta_title'], 'required'],
            [['about', 'smtp_hash'], 'string'],
            [['smtp_port'], 'integer'],
            [['app_name', 'app_owner', 'admin_email', 'from_email', 'address', 'app_logo', 'footer_logo', 'currency', 'location', 'Geocode', 'telephone', 'copyright_text', 'meta_title', 'meta_tag', 'meta_tag_description', 'smtp_email', 'smtp_username', 'smtp_password'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'app_name' => Yii::t('app', 'App Name'),
            'app_owner' => Yii::t('app', 'App Owner'),
            'admin_email' => Yii::t('app', 'Admin Email'),
            'from_email' => Yii::t('app', 'From Email'),
            'address' => Yii::t('app', 'Address'),
            'app_logo' => Yii::t('app', 'App Logo'),
            'footer_logo' => Yii::t('app', 'Footer Logo'),
            'currency' => Yii::t('app', 'Currency'),
            'location' => Yii::t('app', 'Location'),
            'Geocode' => Yii::t('app', 'Geocode'),
            'telephone' => Yii::t('app', 'Telephone'),
            'copyright_text' => Yii::t('app', 'Copyright Text'),
            'about' => Yii::t('app', 'About'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_tag' => Yii::t('app', 'Meta Tag'),
            'meta_tag_description' => Yii::t('app', 'Meta Tag Description'),
            'smtp_email' => Yii::t('app', 'Smtp Email'),
            'smtp_username' => Yii::t('app', 'Smtp Username'),
            'smtp_password' => Yii::t('app', 'Smtp Password'),
            'smtp_hash' => Yii::t('app', 'Smtp Hash'),
            'smtp_port' => Yii::t('app', 'Smtp Port'),
        ];
    }
}
