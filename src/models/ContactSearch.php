<?php

namespace ser6io\yii2contacts\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use ser6io\yii2contacts\models\Contact;

/**
 * ContactSearch represents the model behind the search form of `ser6io\yii2contacts\models\Contact`.
 */
class ContactSearch extends Contact
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'type', 'sub_type', 'organization_id', 'contact_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'isDeleted'], 'integer'],
            [['nickname', 'name', 'website', 'email', 'phone', 'mobile', 'notes', 'metadata'], 'safe'],
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
        $query = Contact::find()->filterDeleted(Yii::$app->request->get('filter_deleted'));

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
            'type' => $this->type,
            'sub_type' => $this->sub_type,
            'organization_id' => $this->organization_id,
            'contact_id' => $this->contact_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'isDeleted' => $this->isDeleted,
        ]);

        $query->andFilterWhere(['like', 'nickname', $this->nickname])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'mobile', $this->mobile])
            ->andFilterWhere(['like', 'notes', $this->notes])
            ->andFilterWhere(['like', 'metadata', $this->metadata]);

        return $dataProvider;
    }
}
