<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "nesting_has_geo".
 *
 * @property int $id
 * @property int $nesting_id
 * @property int $geo_id
 * @property int $count
 *
 * @property Geo $geo
 * @property Nesting $nesting
 */
class NestingHasGeo extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'nesting_has_geo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nesting_id', 'geo_id'], 'required'],
            [['nesting_id', 'geo_id', 'count'], 'integer'],
            [['geo_id'], 'exist', 'skipOnError' => true, 'targetClass' => Geo::className(), 'targetAttribute' => ['geo_id' => 'id']],
            [['nesting_id'], 'exist', 'skipOnError' => true, 'targetClass' => Nesting::className(), 'targetAttribute' => ['nesting_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nesting_id' => 'Nesting ID',
            'geo_id' => 'Geo ID',
            'count' => 'Count',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getGeo()
    {
        return $this->hasOne(Geo::className(), ['id' => 'geo_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNesting()
    {
        return $this->hasOne(Nesting::className(), ['id' => 'nesting_id']);
    }
}
