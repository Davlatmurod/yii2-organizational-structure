<?php

namespace andahrm\structure\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\structure\models\FiscalYear;
use andahrm\setting\models\Helper;

/**
 * FiscalYearSearch represents the model behind the search form of `andahrm\structure\models\FiscalYear`.
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
            [['phase', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
        
        $dataProvider->sort->defaultOrder = [
            'year' => SORT_DESC,
            'phase' => SORT_ASC,
            ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'year' => $this->year ? (intval($this->year) - Helper::YEAR_TH_ADD) : null,
            'phase' => $this->phase,
            // 'date_start' => $this->date_start ? Helper::dateUi2Db($this->date_start) : null,
            // 'date_end' => $this->date_end,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);

        $query->andFilterWhere(['like', 'note', $this->note]);
        $query->andFilterWhere(['=', 'DATE(date_start)', $this->date_start ? Helper::dateUi2Db($this->date_start) : null]);
        $query->andFilterWhere(['=', 'DATE(date_end)', $this->date_end ? Helper::dateUi2Db($this->date_end) : null]);

        return $dataProvider;
    }
}
