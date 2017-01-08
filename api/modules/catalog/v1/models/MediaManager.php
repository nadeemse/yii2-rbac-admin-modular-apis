<?php

namespace api\modules\catalog\v1\models;

use Yii;

/**
 * This is the model class for table "media_manager".
 *
 * @property integer $id
 * @property string $type
 * @property string $name
 * @property string $href
 * @property integer $parent_id
 * @property string $created_at
 */
class MediaManager extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     * @return string table name
     */
    public static function tableName()
    {
        return 'media_manager';
    }

    /**
     * @inheritdoc
     * @return array of rules
     */
    public function rules()
    {
        return [
            [['type'], 'string'],
            [['name'], 'required'],
            [['parent_id'], 'integer'],
            [['created_at'], 'safe'],
            [['name', 'href', 'path'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     * @return array of attributes labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'name' => 'Name',
            'href' => 'Href',
            'path' => 'Path',
            'parent_id' => 'Parent ID',
            'created_at' => 'Created At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFolders()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id'])->where(['type' => 'folder']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFiles()
    {
        return $this->hasMany(self::className(), ['parent_id' => 'id'])->where(['type' => 'file']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(self::className(), ['id' => 'parent_id'])->where(['type' => 'folder']);
    }

    /**
     * @param array $relations this is model relation that need to deleted
     * @return \yii\db\ActiveQuery
     */
    public function deleteRecursive($relations = []) {

        foreach ($relations as $relation) {
            if (is_array($this->$relation)) {
                foreach ($this->$relation as $relationItem) {
                    $relationItem->deleteRecursive($relations);
                }
            } else {
                if (isset($this->$relation)) {
                    $this->$relation->deleteRecursive($relations);
                }
            }
        }

        $this->delete();

        return true;
    }
}
