<?php

namespace api\modules\catalog\v1\models;

use api\core\helpers\ArrayHelper;
use api\modules\settings\v1\models\Areas;
use api\modules\settings\v1\models\Cities;
use Yii;
use yii\data\ActiveDataProvider;

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
 * @property Categories $category
 */
class Items extends \yii\db\ActiveRecord
{
    /**
     * Search Keywords
     * */
    public $keywords;
    public $city;
    public $category;
    public $priceFrom;
    public $priceTo;
    public $withImageOnly;
    public $englishOnly;
    public $itemArea;
    public $location;

    public $itemImages = [];

    /**
     * Extra fields
     * */
    public function extraFields()
    {
        return [
            'itemCategory',
            'area'
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'items';
    }

    /**
     * Fields
     * */
    public function fields() {
        $fields = parent::fields();
        $fields[] = 'location';
        return $fields;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'price', 'seller_id', 'category_id', 'area_id'], 'required'],
            [['seller_id', 'category_id', 'condition_id', 'status', 'area_id'], 'integer'],
            [['description'], 'string'],
            [['created_at', 'updated_at', 'latitude', 'longitude'], 'safe'],

            [['itemArea', 'keywords', 'priceFrom', 'priceTo', 'city', 'category'], 'safe'],

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
    public function getItemCategory()
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
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = self::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => 5,
            ],
        ]);

        $this->load($params);

        /**
         * check if city is set
         * */
        if( $this->city ) {

            $city = Cities::findOne(['name' => $this->city]);
            if( $city !== null && $city->areas) {
                $areas = ArrayHelper::map($city->areas, 'id', 'id');
            }
        }

        /*
         * */
        if( $this->itemArea ) {
            $area = Areas::findOne(['name' => $this->itemArea]);

            if( $area !== null ) {
                $areas = $area->id;
            }
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'seller_id' => $this->seller_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'meta_keywords', $this->meta_keywords])
            ->andFilterWhere(['like', 'meta_description', $this->meta_description])
            ->andFilterWhere(['like', 'meta_title', $this->meta_title]);

        if($this->withImageOnly) {
            $query->andFilterWhere(['!=', 'image', 'null']);
        }

        /**
         * if category is set
         * */
        if( $this->category ) {

            $category = Categories::findOne(['slug' => $this->category]);
            if( $category !== null ) {
                $query->andFilterWhere(['category_id' => $category->id]);
            }
        }

        /**
         * If areas selected
         * */
        if( isset($areas) ) {
            $query->andFilterWhere(['IN', 'area_id', $areas ]);
        }

        /**
         * If areas selected
         * */
        if( $this->status ) {
            $query->andFilterWhere(['IN', 'status', $this->status ]);
        }

        /**
         * Price Conditions
         * */
        if($this->keywords) {
            $query->andFilterWhere(['like', 'name', $this->keywords]);
        }

        /**
         * Price Conditions
         * */

        if($this->priceFrom && $this->priceTo) {
            $query->andFilterWhere(['between', 'price', $this->priceFrom, $this->priceTo]);
        } else {

            if($this->priceFrom) {
                $query->andFilterWhere(['>=', 'price', $this->priceFrom]);
            }

            if($this->priceTo) {
                $query->andFilterWhere(['<=', 'price', $this->priceTo]);
            }

        }

        /*echo $query->createCommand()->rawSql;
        die();*/

        return $dataProvider;
    }

    /**
     * Before Save Function
     * */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {

            $this->seo_url = str_replace(' ', '-', $this->name);
            $this->meta_keywords = str_replace(' ', ',', $this->name);
            $this->meta_description = $this->name;
            $this->meta_title = $this->name;

            return true;
        } else {
            return false;
        }
    }

    /**
     * after Find function
     * */
    public function afterFind() {
        $this->location = [
            'country' => $this->area->city->country->country_name,
            'city' => $this->area->city->name,
            'area' => $this->area->name,
        ];
    }

}
