<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entity_in_work".
 *
 * @property string $id
 * @property int $entity_id
 * @property string $status
 *
 * @property EntityInWorkAggregate[] $entityInWorkAggregates
 */
class EntityInWork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity_in_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_id', 'status'], 'required'],
            [['entity_id'], 'integer'],
            [['status'], 'string'],
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
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityInWorkAggregates()
    {
        return $this->hasMany(EntityInWorkAggregate::className(), ['entity_in_work_id' => 'id']);
    }
}
