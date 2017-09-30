<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nesting".
 *
 * @property int $id
 * @property string $name Название
 * @property int $x Длина
 * @property int $y Ширина
 * @property int $s Толщина
 * @property string $material Материал
 * @property string $time Время
 * @property string $tools Инструмент
 * @property int $category_id Категория
 *
 * @property NestingHasGeo[] $nestingHasGeos
 * @property NestingInWork[] $nestingInWorks
 */
class Nesting extends \yii\db\ActiveRecord
{
    public $type = 'nesting';
    public $geosForm;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nesting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'x', 'y', 's', 'category_id'], 'required'],
            [['x', 'y', 's', 'category_id'], 'integer'],
            [['time'], 'safe'],
            [['tools'], 'string'],
            [['name', 'material'], 'string', 'max' => 255],
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
            'name' => 'Название',
            'x' => 'Длина',
            'y' => 'Ширина',
            's' => 'Толщина',
            'material' => 'Материал',
            'time' => 'Время',
            'tools' => 'Инструмент',
            'size' => 'Габариты',
            'category_name' => 'Категория',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNestingHasGeos()
    {
        return $this->hasMany(NestingHasGeo::className(), ['nesting_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeos()
    {
        return $this->hasMany(Geo::className(), ['id' => 'geo_id'])
            ->viaTable('nesting_has_geo', ['nesting_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNestingInWorks()
    {
        return $this->hasMany(NestingInWork::className(), ['nesting_id' => 'id']);
    }
    
    public function getSize()
    {
        return "{$this->x}x{$this->y}x{$this->s}";
    }
    
    public static function getMaterials()
    {
        return [
            'Х/К', 'ОЦ', 'НЕРЖ',
        ];
    }
    
    public static function getSizes()
    {
        return [
            '2000x1000', '2500x1250',
        ];
    }
    
    public static function getThickness()
    {
        return [
            '8', '10', '15', '20',
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id']);
    }
    
    public function getIcon()
    {
        return '/images/jnf.ico';
    }
}
