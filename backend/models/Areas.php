<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "areas".
 *
 * @property integer $id
 * @property string $name
 * @property integer $city_id
 * @property integer $area_code
 * @property string $description
 * @property integer $status
 *
 * @property Cities $city
 */
class Areas extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'city_id', 'area_code'], 'required'],
            [['city_id', 'status'], 'integer'],
            [['area_code'], 'string', 'max' => 20],
            [['name', 'description'], 'string', 'max' => 255],
            [['city_id'], 'exist', 'skipOnError' => true, 'targetClass' => Cities::className(), 'targetAttribute' => ['city_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
            'city_id' => Yii::t('app', 'City ID'),
            'area_code' => Yii::t('app', 'Area Code'),
            'description' => Yii::t('app', 'Description'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCity()
    {
        return $this->hasOne(Cities::className(), ['id' => 'city_id']);
    }
}
