<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "geo".
 *
 * @property int $id
 * @property int $entity_id
 * @property string $name Название
 * @property int $count Количество
 * @property string $x Длина
 * @property string $y Ширина
 * @property int $s Толщина
 * @property int $category_id Категория
 *
 * @property NestingHasGeo[] $nestingHasGeos
 */
class Geo extends \yii\db\ActiveRecord
{
    public $category_name;
    public $type = 'geo';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'geo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 's', 'category_id'], 'required'],
            [['entity_id', 'count', 's', 'category_id'], 'integer'],
            [['x', 'y'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_id' => 'Entity ID',
            'name' => 'Название',
            'count' => 'Количество',
            'x' => 'Длина',
            'y' => 'Ширина',
            's' => 'Толщина',
            'category_name' => 'Категория',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNestingHasGeos()
    {
        return $this->hasMany(NestingHasGeo::className(), ['geo_id' => 'id']);
    }
    
    public function getIcon()
    {
        return '/images/jgf.ico';
    }
}
