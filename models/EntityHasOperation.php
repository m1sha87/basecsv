<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entity_has_operation".
 *
 * @property string $id
 * @property int $entity_id
 * @property int $operation_id
 * @property string $comment
 * @property int $order
 * @property string $value
 * @property string $time
 *
 * @property Operation $operation
 * @property EntityInWorkAggregate[] $entityInWorkAggregates
 */
class EntityHasOperation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity_has_operation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'operation_id'], 'required'],
            [['entity_id', 'operation_id', 'order'], 'integer'],
            [['comment'], 'string'],
            [['value'], 'number'],
            [['time'], 'safe'],
            [['operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => Operation::className(), 'targetAttribute' => ['operation_id' => 'id']],
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
            'operation_id' => 'Operation ID',
            'comment' => 'Comment',
            'order' => 'Order',
            'value' => 'Value',
            'time' => 'Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOperation()
    {
        return $this->hasOne(Operation::className(), ['id' => 'operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityInWorkAggregates()
    {
        return $this->hasMany(EntityInWorkAggregate::className(), ['entity_has_operation_id' => 'id']);
    }
}
