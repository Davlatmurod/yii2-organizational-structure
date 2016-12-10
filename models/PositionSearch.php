<?php

namespace andahrm\structure\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\structure\models\Position;

/**
 * PositionSearch represents the model behind the search form about `andahrm\structure\models\Position`.
 */
class PositionSearch extends Position
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'person_type_id', 'section_id', 'position_type_id', 'number', 'min_salary', 'max_salary'], 'integer'],
            [['name_manage', 'name_work', 'note'], 'safe'],
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
        $query = Position::find();

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
            'person_type_id' => $this->person_type_id,
            'section_id' => $this->section_id,
            'position_type_id' => $this->position_type_id,
            'number' => $this->number,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
        ]);

        $query->andFilterWhere(['like', 'name_manage', $this->name_manage])
            ->andFilterWhere(['like', 'name_work', $this->name_work])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
