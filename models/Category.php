<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name Название категории
 * @property int $parent_id Родительская категория
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
            [['parent_id'], 'integer'],
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
            'parent_id' => 'Родительская категория',
        ];
    }
    
    public static function getAllCategories()
    {
        $categories = self::find()->orderBy(['parent_id' => SORT_ASC, 'name'  => SORT_ASC])->asArray()->all();
        $result = [];
        $level = 0;
        $currentParentId = 0;
        foreach ($categories as $category)
        {
            if ($currentParentId != $category['parent_id']) {
                $level++;
                $currentParentId = $category['parent_id'];
            }
            $prefix = str_repeat('--', $level);
            $result[$currentParentId][$category['id']] = $prefix.$category['name'];
        }
        return $result;
    }
    
    
}
