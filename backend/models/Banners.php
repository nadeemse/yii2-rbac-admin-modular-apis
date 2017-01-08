<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property string $name
 * @property string $slug
 * @property string $type
 * @property integer $status
 *
 * @property BannerImages[] $bannerImages
 */
class Banners extends \yii\db\ActiveRecord
{
    /**
     * Images Array for this Model
     * */
    public $images = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'slug'], 'required'],
            [['type'], 'string'],
            [['status'], 'integer'],
            [['images'], 'safe'],
            [['name', 'slug'], 'string', 'max' => 255],
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
            'slug' => Yii::t('app', 'Slug'),
            'type' => Yii::t('app', 'Type'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes) {

        BannerImages::deleteAll(['banner_id' => $this->id]);
        // Save ALL banners Images

        foreach($this->images as $image) {

            $bannerImage = new BannerImages();
            $bannerImage->attributes = $image;
            $bannerImage->banner_id = $this->id;
            $bannerImage->save();
        }
    }


    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBannerImages()
    {
        return $this->hasMany(BannerImages::className(), ['banner_id' => 'id']);
    }
}
