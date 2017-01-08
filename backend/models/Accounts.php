<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "accounts".
 *
 * @property integer $id
 * @property string $email
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property integer $status
 * @property integer $amazing_offers
 * @property integer $occasional_updates
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $account_type
 * @property string $first_name
 * @property string $last_name
 * @property string $dob
 * @property integer $gender
 * @property integer $country
 * @property string $socialType
 * @property string $socialID
 *
 * @property Customers[] $customers
 * @property Sellers[] $sellers
 */
class Accounts extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'accounts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['email', 'auth_key', 'password_hash', 'created_at', 'updated_at', 'first_name'], 'required'],
            [['status', 'amazing_offers', 'occasional_updates', 'created_at', 'updated_at', 'gender', 'country'], 'integer'],
            [['account_type', 'socialType'], 'string'],
            [['dob'], 'safe'],
            [['email', 'password_hash', 'password_reset_token', 'first_name', 'last_name', 'socialID'], 'string', 'max' => 255],
            [['auth_key'], 'string', 'max' => 64],
            [['email'], 'unique'],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'email' => Yii::t('app', 'Email'),
            'auth_key' => Yii::t('app', 'Auth Key'),
            'password_hash' => Yii::t('app', 'Password Hash'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'status' => Yii::t('app', 'Status'),
            'amazing_offers' => Yii::t('app', 'Amazing Offers'),
            'occasional_updates' => Yii::t('app', 'Occasional Updates'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'account_type' => Yii::t('app', 'Account Type'),
            'first_name' => Yii::t('app', 'First Name'),
            'last_name' => Yii::t('app', 'Last Name'),
            'dob' => Yii::t('app', 'Dob'),
            'gender' => Yii::t('app', 'Gender'),
            'country' => Yii::t('app', 'Country'),
            'socialType' => Yii::t('app', 'Social Type'),
            'socialID' => Yii::t('app', 'Social ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCustomers()
    {
        return $this->hasMany(Customers::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSellers()
    {
        return $this->hasMany(Sellers::className(), ['account_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccountCountry()
    {
        return $this->hasOne(Country::className(), ['id' => 'country']);
    }

}
