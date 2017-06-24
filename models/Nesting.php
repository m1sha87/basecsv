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
 * @property string $time Время
 * @property string $tools Инструмент
 *
 * @property NestingHasGeo[] $nestingHasGeos
 * @property NestingInWork[] $nestingInWorks
 */
class Nesting extends \yii\db\ActiveRecord
{
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
            [['name', 'x', 'y', 's'], 'required'],
            [['x', 'y', 's'], 'integer'],
            [['time'], 'safe'],
            [['tools'], 'string'],
            [['name'], 'string', 'max' => 255],
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
            'time' => 'Время',
            'tools' => 'Инструмент',
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
    public function getNestingInWorks()
    {
        return $this->hasMany(NestingInWork::className(), ['nesting_id' => 'id']);
    }
}
