<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "banner_images".
 *
 * @property integer $id
 * @property integer $banner_id
 * @property string $title
 * @property string $description
 * @property string $image
 * @property string $link
 * @property integer $sort_order
 * @property integer $status
 *
 * @property Banners $banner
 */
class BannerImages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_images';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['banner_id', 'image'], 'required'],
            [['banner_id', 'sort_order', 'status'], 'integer'],
            [['title', 'description', 'image', 'link'], 'string', 'max' => 255],
            [['banner_id'], 'exist', 'skipOnError' => true, 'targetClass' => Banners::className(), 'targetAttribute' => ['banner_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'banner_id' => Yii::t('app', 'Banner ID'),
            'title' => Yii::t('app', 'Title'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'link' => Yii::t('app', 'Link'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'status' => Yii::t('app', 'Status'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanner()
    {
        return $this->hasOne(Banners::className(), ['id' => 'banner_id']);
    }
}
