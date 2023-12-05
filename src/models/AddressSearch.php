<?php

namespace ser6io\yii2contacts\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ser6io\yii2contacts\models\Address;

/**
 * AddressSearch represents the model behind the search form of `ser6io\yii2contacts\models\Address`.
 */
class AddressSearch extends Address
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'contact_id', 'created_at', 'updated_at'], 'integer'],
            [['type', 'line_1', 'line_2', 'city', 'state', 'zip', 'country'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Address::find()->filterDeleted(Yii::$app->request->get('filter_deleted'));

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'contact_id' => $this->contact_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'line_1', $this->line_1])
            ->andFilterWhere(['like', 'line_2', $this->line_2])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'state', $this->state])
            ->andFilterWhere(['like', 'zip', $this->zip])
            ->andFilterWhere(['like', 'country', $this->country]);

        return $dataProvider;
    }
}
