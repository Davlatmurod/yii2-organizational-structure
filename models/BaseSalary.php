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
            //[['person_type_id', 'step', 'position_type_id', 'position_level_id', 'salary'], 'required'],
            [['person_type_id', 'step', 'position_type_id', 'salary'], 'required'],
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
    
    public $diff;

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/structure', 'ID'),
            'person_type_id' => Yii::t('andahrm/structure', 'Person Type'),
            'step' => Yii::t('andahrm/structure', 'Step'),
            'position_type_id' => Yii::t('andahrm/structure', 'Position Type'),
            'position_level_id' => Yii::t('andahrm/structure', 'Position Level'),
            'title' => Yii::t('andahrm/structure', 'Title'),
            'salary' => Yii::t('andahrm/structure', 'Salary'),
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
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
        $str = $this->position_type_id?(($this->person_type_id==1)?'ประเภท':'').$this->positionType->title:'';
        $str .=$this->position_level_id?'ระดับ'.$this->positionLevel->title:'';
        return $str;
    }
  
    public function getPositionCode()
    {
        $str = [];
        $str[] = $this->person_type_id;
        $str[] = $this->position_type_id;
        $str[] = $this->position_level_id;
        $str = array_filter($str);
        return implode('-',$str);
    }
  
   public static function getBaseSalaryByPersonType($person_type_id){
     $data = [];
     $newData = [];
     $newStep = [];
     $newPostion = [];
     if($person_type_id){
       
       $modelPersonType = PersonType::find()->where(['id'=>$person_type_id])->select('step_max')->one();
       
       /**
       ดึงของมูลทั้งหมด โดยใช้ step เป็น key หลักและให้ positionCode เป็น key รอง
       */
     $data = self::find()
       ->select(['step','person_type_id','position_type_id','position_level_id',
                 '(CAST(`salary` AS CHAR)+0) as salary',
                 'id'])
       ->where(['person_type_id'=>$person_type_id])
       ->orderBy([
         'step'=>SORT_ASC,
         'position_type_id'=>SORT_ASC,
         'position_level_id'=>SORT_ASC,
       ])
       ->all();
       $newData = ArrayHelper::index($data,'positionCode', 'step');
       $step = [];
       //foreach(range(1,$modelPersonType->step_max,0.5) as $s){
       foreach(range($modelPersonType->step_max,1,0.5) as $s){
         $step[Yii::$app->formatter->asDecimal($s,1)] = [];
       }
       
       
       
       $newData = ArrayHelper::merge($step,$newData);
//        echo "<pre>";       
//        print_r($newData);
//        exit();
       
       /**
       ดึงข้อมูลประเภทกับระดับออกมา
       */
       $dataPosition = self::find()
       ->select(['step','person_type_id','position_type_id','position_level_id','salary'])
       ->where(['person_type_id'=>$person_type_id])
       ->groupBy(['position_type_id','position_level_id'])
       ->orderBy([
         'position_type_id'=>SORT_ASC,
         'position_level_id'=>SORT_ASC,
       ])
       ->all();
       
       $newPostion = ArrayHelper::map($dataPosition,'positionCode','title');
     }
     
     return [
       $newPostion,
       $newData
     ];
   }
  
  
  public static function getPositionTypes($person_type_id)
    {
        if($person_type_id){
          return ArrayHelper::map(
            PositionType::find()->where([
               'person_type_id'=>$person_type_id
            ])->all()
            ,'id','title');
        }
          return [];
    }
  
  public static function getPositionLevels($position_type_id)
    {
        if($position_type_id){
          return ArrayHelper::map(
            PositionLevel::find()->where([
               'position_type_id'=>$position_type_id
            ])->all()
            ,'id','title');
        }
          return [];
    }
  
  
}
