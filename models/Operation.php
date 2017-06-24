<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operation".
 *
 * @property int $id
 * @property string $name Название
 * @property string $unit Ед. измерения
 * @property int $area_id Участок
 *
 * @property EntityHasOperation[] $entityHasOperations
 * @property Area $area
 */
class Operation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'area_id'], 'required'],
            [['area_id'], 'integer'],
            [['name', 'unit'], 'string', 'max' => 255],
            [['area_id'], 'exist', 'skipOnError' => true, 'targetClass' => Area::className(), 'targetAttribute' => ['area_id' => 'id']],
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
            'unit' => 'Ед. измерения',
            'area_id' => 'Участок',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityHasOperations()
    {
        return $this->hasMany(EntityHasOperation::className(), ['operation_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(Area::className(), ['id' => 'area_id']);
    }
}
