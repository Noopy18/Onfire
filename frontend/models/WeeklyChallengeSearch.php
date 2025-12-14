<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\WeeklyChallenge;

/**
 * WeeklyChallengeSearch represents the model behind the search form of `frontend\models\WeeklyChallenge`.
 */
class WeeklyChallengeSearch extends WeeklyChallenge
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['weekly_challenge_id', 'status'], 'integer'],
            [['name', 'description', 'start_date'], 'safe'],
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
     * @param string|null $formName Form name to be used into `->load()` method.
     *
     * @return ActiveDataProvider
     */
    public function search($params, $formName = null)
    {
        $query = WeeklyChallenge::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params, $formName);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'weekly_challenge_id' => $this->weekly_challenge_id,
            'start_date' => $this->start_date,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
