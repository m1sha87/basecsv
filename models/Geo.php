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
 *
 * @property NestingHasGeo[] $nestingHasGeos
 */
class Geo extends \yii\db\ActiveRecord
{
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
            [['entity_id', 'name', 's'], 'required'],
            [['entity_id', 'count', 's'], 'integer'],
            [['x', 'y'], 'number'],
            [['name'], 'string', 'max' => 255],
            [['name'], 'unique'],
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
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNestingHasGeos()
    {
        return $this->hasMany(NestingHasGeo::className(), ['geo_id' => 'id']);
    }
}
