<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "color".
 *
 * @property int $id
 * @property string $name Краска
 *
 * @property EntityHasColor[] $entityHasColors
 */
class Color extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
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
            'name' => 'Краска',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityHasColors()
    {
        return $this->hasMany(EntityHasColor::className(), ['color_id' => 'id']);
    }
}
