<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "entity_has_entity".
 *
 * @property string $id
 * @property int $parent_id
 * @property int $child_id
 * @property int $count Количество
 */
class EntityHasEntity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'entity_has_entity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['parent_id', 'child_id'], 'required'],
            [['parent_id', 'child_id', 'count'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'parent_id' => 'Parent ID',
            'child_id' => 'Child ID',
            'count' => 'Количество',
        ];
    }
}
