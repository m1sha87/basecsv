<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * EntitySearch represents the model behind the search form of `app\models\Entity`.
 */
class EntitySearch extends Entity
{
    public function attributes()
    {
        return array_merge(parent::attributes(), ['category.name']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'type', 'sku', 'category.name'], 'safe'],
        ];
    }
    
    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Entity::find();
        $query->joinWith('category');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
    
        $dataProvider->sort->attributes['category.name'] =
            [
                'asc' => ['category.name' => SORT_ASC],
                'desc' => ['category.name' => SORT_DESC],
            ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'entity.id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'sku', $this->sku])
            ->andFilterWhere(['like', 'category.name', $this->getAttribute('category.name')]);

        return $dataProvider;
    }
}
