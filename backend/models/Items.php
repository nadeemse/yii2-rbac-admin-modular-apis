<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "items".
 *
 * @property integer $id
 * @property string $name
 * @property string $price
 * @property integer $seller_id
 * @property integer $category_id
 * @property integer $age_id
 * @property integer $usage_id
 * @property integer $condition_id
 * @property string $description
 * @property string $image
 * @property integer $status
 * @property string $created_at
 * @property string $updated_at
 * @property string $seo_url
 * @property string $meta_title
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $area_id
 * @property string $latitude
 * @property string $longitude
 *
 * @property ItemImages[] $itemImages
 * @property Categories $category
 */
class Items extends \yii\db\ActiveRecord
{
    public $images = [];
    /**
     * @inheritdoc
     * @return string table name
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'seller_id', 'category_id', 'age_id', 'usage_id', 'condition_id', 'area_id'], 'required'],
            [['seller_id', 'category_id', 'age_id', 'usage_id', 'condition_id', 'status', 'area_id'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'latitude', 'longitude', 'images'], 'safe'],
            [['name', 'price', 'image', 'seo_url', 'meta_title', 'meta_keywords', 'meta_description', 'latitude', 'longitude'], 'string', 'max' => 255],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::className(), 'targetAttribute' => ['category_id' => 'id']],
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
            'price' => Yii::t('app', 'Price'),
            'seller_id' => Yii::t('app', 'Seller ID'),
            'category_id' => Yii::t('app', 'Category ID'),
            'age_id' => Yii::t('app', 'Age ID'),
            'usage_id' => Yii::t('app', 'Usage ID'),
            'condition_id' => Yii::t('app', 'Condition ID'),
            'description' => Yii::t('app', 'Description'),
            'image' => Yii::t('app', 'Image'),
            'status' => Yii::t('app', 'Status'),
            'created_at' => Yii::t('app', 'Created At'),
            'updated_at' => Yii::t('app', 'Updated At'),
            'seo_url' => Yii::t('app', 'Seo Url'),
            'meta_title' => Yii::t('app', 'Meta Title'),
            'meta_keywords' => Yii::t('app', 'Meta Keywords'),
            'meta_description' => Yii::t('app', 'Meta Description'),
            'area_id' => Yii::t('app', 'Area'),
            'latitude' => Yii::t('app', 'Latitude'),
            'longitude' => Yii::t('app', 'Longitude'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemImages()
    {
        return $this->hasMany(ItemImages::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Categories::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Areas::className(), ['id' => 'area_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getItemUsages()
    {
        return $this->hasOne(ItemUsages::className(), ['id' => 'usage_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSeller()
    {
        return $this->hasOne(Accounts::className(), ['id' => 'seller_id']);
    }

    /**
     * Item Status
     * */
    public function getItemstatus() {

        if($this->status == 1) {
            return 'Active';
        } else if($this->status == 2) {
            return 'Awaiting Approval';
        } else if($this->status == 3) {
            return 'Suspended';
        } else {
            return 'Deleted';
        }
    }

    /**
     * @inheritdoc
     * @param boolean $insert            true or false
     * @param array   $changedAttributes list of attributes
     * @return null
     */
    public function afterSave($insert, $changedAttributes) {

        ItemImages::deleteAll(['item_id' => $this->id]);
        foreach ($this->images as $image) {

            $itemImage = new ItemImages();
            $itemImage->attributes = $image;
            $itemImage->item_id = $this->id;
            $itemImage->save();
        }
    }
}
