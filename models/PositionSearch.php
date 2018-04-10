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
            [['id', 'person_type_id', 'section_id', 'position_line_id', 'number', 'position_type_id', 'position_level_id', 'min_salary', 'max_salary','status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title', 'note' , 'code'], 'safe'],
        ];
    }
    
    public $code;

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
            'position_line_id' => $this->position_line_id,
            //'number' => $this->number,
            'position_type_id' => $this->position_type_id,
            'position_level_id' => $this->position_level_id,
            'min_salary' => $this->min_salary,
            'max_salary' => $this->max_salary,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
        ]);
        
        // if($this->code){
        //     $code = explode('-',$this->code);
        //     if($code[0]=='46'){
        //     $personTypeCode = $code[0].(isset($code[1])?'-'.$code[1]:'');
        //     $sectionCode = isset($code[2])?$code[2]:null;
        //     $positionLineCode = isset($code[3])?$code[3]:null;
        //     $number = isset($code[4])?$code[4]*1:null;
        //     }else{
        //     $personTypeCode = $code[0];
        //     $sectionCode = isset($code[1])?$code[1]:null;
        //     $positionLineCode = isset($code[2])?$code[2]:null;
        //     $number = isset($code[3])?$code[3]*1:null;
        //     }
            
        //   $query->joinWith("personType");
        //   $query->andFilterWhere(['like', 'person_type.code', $personTypeCode]);
           
        //   $query->joinWith("section");
        //   $query->andFilterWhere(['like', 'section.code', $sectionCode]);
           
        //   $query->joinWith("positionLine");
        //   $query->andFilterWhere(['like', 'position_line.code', $positionLineCode]);
           
        //   $query->andFilterWhere(['like', 'number', $number]);
        // }

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'code', $this->code])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
