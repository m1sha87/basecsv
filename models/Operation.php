<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "operation".
 *
 * @property int $id
 * @property string $name Название
 * @property string $unit Ед. измерения
 *
 * @property EntityHasOperation[] $entityHasOperations
 * @property OperationHasArea[] $operationHasAreas
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
            [['name'], 'required'],
            [['name', 'unit'], 'string', 'max' => 255],
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
            'areas' => 'Участки',
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
    public function getOperationHasAreas()
    {
        return $this->hasMany(OperationHasArea::className(), ['operation_id' => 'id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAreas()
    {
        return $this->hasMany(Area::className(), ['id' => 'area_id'])
            ->viaTable('operation_has_area', ['operation_id' => 'id']);
    }
}