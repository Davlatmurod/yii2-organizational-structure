<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "base_salary".
 *
 * @property integer $id
 * @property integer $person_type_id
 * @property string $step
 * @property integer $position_type_id
 * @property integer $position_level_id
 * @property string $title
 * @property string $salary
 * @property string $note
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property PositionLevel $positionLevel
 * @property PersonType $personType
 * @property PositionType $positionType
 */
class BaseSalary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'base_salary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['person_type_id', 'step', 'position_type_id', 'position_level_id', 'salary'], 'required'],
            [['person_type_id', 'position_type_id', 'position_level_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['step', 'salary'], 'number'],
            [['title', 'note'], 'string', 'max' => 255],
            [['position_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionLevel::className(), 'targetAttribute' => ['position_level_id' => 'id']],
            [['person_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonType::className(), 'targetAttribute' => ['person_type_id' => 'id']],
            [['position_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionType::className(), 'targetAttribute' => ['position_type_id' => 'id']],
        ];
    }
  
   function behaviors()
    {
        return [ 
          'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/structure', 'ID'),
            'person_type_id' => Yii::t('andahrm/structure', 'ประเภทบุคลากร'),
            'step' => Yii::t('andahrm/structure', 'ขั้น'),
            'position_type_id' => Yii::t('andahrm/structure', 'ประเภทตำแหน่ง'),
            'position_level_id' => Yii::t('andahrm/structure', 'ระดับ'),
            'title' => Yii::t('andahrm/structure', 'ประเภท/ระดับ'),
            'salary' => Yii::t('andahrm/structure', 'อัตราเงินเดือน'),
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm/structure', 'Created At'),
            'created_by' => Yii::t('andahrm/structure', 'Created By'),
            'updated_at' => Yii::t('andahrm/structure', 'Updated At'),
            'updated_by' => Yii::t('andahrm/structure', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionLevel()
    {
        return $this->hasOne(PositionLevel::className(), ['id' => 'position_level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonType()
    {
        return $this->hasOne(PersonType::className(), ['id' => 'person_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionType()
    {
        return $this->hasOne(PositionType::className(), ['id' => 'position_type_id']);
    }
  
    public function getTitle()
    {
        $str = $this->position_type_id?'ประเภท'.$this->positionType->title:'';
        $str .=$this->position_level_id?'ระดับ'.$this->positionLevel->title:'';
        return $str;
    }
  
    public function getPositionCode()
    {
        $str = $this->position_type_id.'-'.$this->position_level_id;
        return $str;
    }
  
   public static function getBaseSalaryByPersonType($person_type_id){
     $data = [];
     $newData = [];
     $newStep = [];
     $newPostion = [];
     if($person_type_id){
     $data = self::find()
       //->distinct('step')
       ->where(['person_type_id'=>$person_type_id])
       //->groupBy('step')
       ->orderBy([
         'step'=>SORT_ASC,
         'position_type_id'=>SORT_ASC,
         'position_level_id'=>SORT_ASC,
       ])
       ->all();
       
       
       $dataPosition = self::find()
       //->distinct('step')
       ->where(['person_type_id'=>$person_type_id])
       ->groupBy(['position_type_id','position_level_id'])
       ->orderBy([
         //'step'=>SORT_ASC,
         'position_type_id'=>SORT_ASC,
         'position_level_id'=>SORT_ASC,
       ])
       ->all();
       
       $newPostion = ArrayHelper::map($dataPosition,'positionCode','title');
       //$newStep = ArrayHelper::map($data,'positionCode','title');
       
       $newData = ArrayHelper::index($data,'positionCode', 'step');
//        $newData = ArrayHelper::index($data, null, [function ($element) {
//             return $element['step'];
//         }, 'positionCode']);
//        echo "<pre>"; 
//        print_r($newPostion);
//        exit(); 
       
//        foreach($postion as $model){
//          //$newStep[] = $model->step;
//          $newPostion[$model->position_type_id.'-'.$model->position_level_id] = $model->title;
//        }
       
       
      //$newData = ArrayHelper::index($data, 'positionCode');
       //$result = ArrayHelper::getColumn($newData, 'id');
       /*
       $newStep= ArrayHelper::index($data, 'step'); 
       $newPostion = [];
       $oldPositionCode = key($newData);
       foreach($data as $model){
         //$newStep[] = $model->step;
         //$newPostion[$model->position_type_id.'-'.$model->position_level_id] = $model->title;
       }
       /*
       $newData = [];
       //$newData[$data[0]->step][$data[0]->position_type_id][$data[0]->position_level_id] = $data[0];
       
      
       $oldStep = $data[0]['step'];
       $oldPositionTypeId = $data[0]['position_type_id'].'-'.$data[0]['position_level_id'];
       foreach($data as $model){
         $positionTypeId =$model->position_type_id.'-'.$model->position_level_id;
         if($oldPositionTypeId!=$positionTypeId){            
           $oldPositionTypeId = $positionTypeId;
         }
         $newData[$positionTypeId] = $model;
         
       }
       
       */
     }
     
     return [
       $newPostion,
       $newData
     ];
   }
  
  
  
  
}
