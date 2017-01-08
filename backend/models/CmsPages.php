<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cms_pages".
 *
 * @property integer $id
 * @property string $title
 * @property string $seo_url
 * @property string $description
 * @property string $short_description
 * @property string $meta_title
 * @property string $meta_description
 * @property string $meta_keywords
 * @property string $seo_keywords
 * @property integer $bottom
 * @property integer $top
 * @property integer $sort_order
 * @property string $banner_image
 * @property integer $status
 */
class CmsPages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cms_pages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'seo_url', 'description', 'meta_title'], 'required'],
            [['description'], 'string'],
            [['bottom', 'top', 'sort_order', 'status'], 'integer'],
            [['title', 'seo_url', 'banner_image', 'short_description'], 'string', 'max' => 255],
            [['meta_title', 'meta_description', 'meta_keywords'], 'string', 'max' => 150],
            [['seo_keywords'], 'string', 'max' => 100],
            [['title'], 'unique'],
            [['seo_url'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'seo_url' => Yii::t('app', 'Seo Url'),
            'description' => Yii::t('app', 'Description'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'short_description' => Yii::t('app', 'Short Description'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'seo_keywords' => Yii::t('app', 'Seo Keywords'),
            'bottom' => Yii::t('app', 'Bottom'),
            'top' => Yii::t('app', 'Top'),
            'sort_order' => Yii::t('app', 'Sort Order'),
            'banner_image' => Yii::t('app', 'Banner Image'),
            'status' => Yii::t('app', 'Status'),
        ];
    }
}
