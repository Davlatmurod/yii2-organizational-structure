<?php

namespace andahrm\structure\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use andahrm\structure\models\PositionLevel;

/**
 * PositionLevelSearch represents the model behind the search form about `andahrm\structure\models\PositionLevel`.
 */
class PositionLevelSearch extends PositionLevel
{
   public $person_type_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'position_type_id','person_type_id', 'note', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'safe'],
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
        $query = PositionLevel::find();

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
            'position_type_id' => $this->position_type_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);
      if($this->person_type_id){
        $query->joinWith('positionType');
        $query->andFilterWhere([
            'position_type.person_type_id' => $this->person_type_id
          ]);
      }

        $query->andFilterWhere(['like', 'title', $this->title])
              ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
