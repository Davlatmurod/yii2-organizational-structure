<?php

namespace andahrm\structure\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use kuakling\datepicker\behaviors\DateBuddhistBehavior;
use andahrm\setting\models\Helper;
/**
 * This is the model class for table "fiscal_year".
 *
 * @property string $year
 * @property string $date_start
 * @property string $date_end
 * @property string $note
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class FiscalYear extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'fiscal_year';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
           [['year', 'phase', 'date_start', 'date_end'], 'required'],
           [['year', 'date_start', 'date_end'], 'safe'],
           [['phase', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'], 
           [['note'], 'string'],
           //[['year', 'phase'], 'unique', 'targetAttribute' => ['year', 'phase'], 'message' => 'มีปีและภาคนี้อยู่แล้ว'],
           //[['phase', ], 'unique', 'targetAttribute' => ['year', 'phase'], 'message' => 'มีปีและภาคนี้อยู่แล้ว'],
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
            'date_start' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'date_start',
            ],
            'date_end' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'date_end',
            ],
        ];
    }

    public $step;
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'year' => Yii::t('andahrm/structure', 'Year'),
            'phase' => Yii::t('andahrm/structure', 'Phase'),
            'date_start' => Yii::t('andahrm/structure', 'Date Start'),
            'date_end' => Yii::t('andahrm/structure', 'Date End'),
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }
  
    public function getYearTh(){
      return $this->year+543;
    }
    
    public function getYearThphase(){
      return $this->yearTh."/".$this->phase;
    }
    
    public static function getList(){
      return ArrayHelper::map(self::find()->orderBy(['year'=>SORT_DESC])->all(),'year','yearTh');
    // พี่เปลี่ยนเป็นปีไทยก่อนนะ มีปัญหาอะไรค่อยว่ากัน
    // return ArrayHelper::map(self::find()->orderBy(['year'=>SORT_DESC])->all(),'yearTh','yearTh');
    }    
  
  
    # น่าจะไม่ใช้แล้ว ไปเช็คใน Controller
    public static function getListSelected(){
      $model = self::find()->all();
      $selected = ArrayHelper::index($model, 'year');
      //print_r($selected);
        foreach($selected as $k=>$item){
         // if($item->phase)
          //$selected[$k]= ['disabled'=>'disabled'];
          $selected[$k]= [];
        }
      return $selected;
    }
  
    public static function getYearAll($start=2000){
      $date_start =  date('Y', strtotime("-5 year"));;
      $date_end=  date('Y', strtotime("+5 year"));
      return array_combine(range($date_end,$date_start),range($date_end+543,$date_start+543));
    }
  
    public static function currentYear($th = null){
      $toDay = date('Y-m-d');
      $model = self::find()
        ->where(['<=','DATE(date_start)',$toDay])
        ->andWhere(['>=','DATE(date_end)',$toDay])
        ->one();
      //echo $model->year;
      //exit();
      return $model?($th?$model->yearTh:$model->year):null;
    }
    
    
    public static function getPhaseList($year){
        return ArrayHelper::map(self::find()->where(['year'=>$year])->orderBy(['year'=>SORT_DESC])->all(),'phase','phaseTitle');
    }
    
    public function getPhaseTitle(){
        return 
       // $this->phase."(".
        Yii::$app->formatter->asDate($this->date_start).' - '.Yii::$app->formatter->asDate($this->date_end)
        //.")"
        ;
    }
    
    public function getDateStart(){
        return Yii::$app->formatter->asDate($this->date_start);
    }
    
    public function getDateEnd(){
        return Yii::$app->formatter->asDate($this->date_end);
    }
    
    public static function getDateBetween($year)
    {
        $model = self::find()
        ->select("MIN(`date_start`) as date_start, MAX(`date_end`) as date_end")
        ->where(['year' => $year])->orderBy('phase')->one();
        
        return $model;
    }
    
  
}
