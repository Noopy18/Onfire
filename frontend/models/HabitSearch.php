<?php

namespace frontend\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Habit;

/**
 * HabitSearch represents the model behind the search form of `frontend\models\Habit`.
 */
class HabitSearch extends Habit
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['habit_id', 'fk_utilizador', 'fk_category'], 'integer'],
            [['name', 'description', 'frequency', 'final_date', 'type', 'created_at'], 'safe'],
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
        $query = Habit::find();

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
            'habit_id' => $this->habit_id,
            'final_date' => $this->final_date,
            'created_at' => $this->created_at,
            'fk_utilizador' => $this->fk_utilizador,
            'fk_category' => $this->fk_category,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'frequency', $this->frequency])
            ->andFilterWhere(['like', 'type', $this->type]);

        return $dataProvider;
    }
}
