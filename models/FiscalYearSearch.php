<?php

namespace andahrm\structure\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\structure\models\FiscalYear;

/**
 * FiscalYearSearch represents the model behind the search form about `andahrm\structure\models\FiscalYear`.
 */
class FiscalYearSearch extends FiscalYear
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['year', 'date_start', 'date_end', 'note'], 'safe'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
        $query = FiscalYear::find();

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
            'year' => $this->year,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
