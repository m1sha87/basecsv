<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entity".
 *
 * @property int $id
 * @property string $name Название
 * @property string $type Тип
 * @property string $sku Артикул
 * @property int $category_id Категория
 *
 * @property Category $category
 * @property EntityHasColor[] $entityHasColors
 * @property EntityHasEntity[] $entityHasEntities
 * @property EntityHasEntity[] $entityHasEntities0
 * @property EntityHasOperation[] $entityHasOperations
 * @property EntityInWork[] $entityInWorks
 * @property Geo[] $geos
 */
class Entity extends \yii\db\ActiveRecord
{
    public $category_name;
    
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type'], 'required'],
            [['type', 'category_name'], 'string'],
            [['category_id'], 'integer'],
            [['name', 'sku'], 'string', 'max' => 255],
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
            'type' => 'Тип',
            'sku' => 'Артикул',
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
    public function getEntityHasColors()
    {
        return $this->hasMany(EntityHasColor::className(), ['entity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityHasEntities()
    {
        return $this->hasMany(EntityHasEntity::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityHasEntities0()
    {
        return $this->hasMany(EntityHasEntity::className(), ['child_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityHasOperations()
    {
        return $this->hasMany(EntityHasOperation::className(), ['entity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityInWorks()
    {
        return $this->hasMany(EntityInWork::className(), ['entity_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeos()
    {
        return $this->hasMany(Geo::className(), ['entity_id' => 'id']);
    }
}
