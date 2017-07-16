<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name Название категории
 * @property int $parent_id Родительская категория
 * @property int $has_childs
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['has_childs'], 'integer'],
            [['parent_id'], 'filter', 'filter' => 'intval'],
            [['parent_id'], 'exist', 'targetAttribute' => 'id'],
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
            'name' => 'Название категории',
            'parent_name' => 'Родительская категория',
        ];
    }
    
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id'])->from(['parent' => Category::tableName()]);
    }
}