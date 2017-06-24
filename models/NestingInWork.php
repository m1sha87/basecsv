<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nesting_in_work".
 *
 * @property string $id
 * @property int $nesting_id Раскладка
 * @property int $is_done Готово
 * @property int $order Порядок
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Nesting $nesting
 * @property User $user
 */
class NestingInWork extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nesting_in_work';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nesting_id'], 'required'],
            [['nesting_id', 'is_done', 'order', 'user_id'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['nesting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nesting::className(), 'targetAttribute' => ['nesting_id' => 'id']],
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
            'nesting_id' => 'Раскладка',
            'is_done' => 'Готово',
            'order' => 'Порядок',
            'user_id' => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNesting()
    {
        return $this->hasOne(Nesting::className(), ['id' => 'nesting_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }
}
