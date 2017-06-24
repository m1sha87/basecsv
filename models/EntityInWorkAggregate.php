<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entity_in_work_aggregate".
 *
 * @property string $id
 * @property string $entity_in_work_id
 * @property string $entity_has_operation_id
 * @property string $status Статус
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property EntityHasOperation $entityHasOperation
 * @property EntityInWork $entityInWork
 * @property User $user
 */
class EntityInWorkAggregate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity_in_work_aggregate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['entity_in_work_id', 'entity_has_operation_id', 'status'], 'required'],
            [['entity_in_work_id', 'entity_has_operation_id', 'user_id'], 'integer'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['entity_has_operation_id'], 'exist', 'skipOnError' => true, 'targetClass' => EntityHasOperation::className(), 'targetAttribute' => ['entity_has_operation_id' => 'id']],
            [['entity_in_work_id'], 'exist', 'skipOnError' => true, 'targetClass' => EntityInWork::className(), 'targetAttribute' => ['entity_in_work_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'entity_in_work_id' => 'Entity In Work ID',
            'entity_has_operation_id' => 'Entity Has Operation ID',
            'status' => 'Статус',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityHasOperation()
    {
        return $this->hasOne(EntityHasOperation::className(), ['id' => 'entity_has_operation_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEntityInWork()
    {
        return $this->hasOne(EntityInWork::className(), ['id' => 'entity_in_work_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
