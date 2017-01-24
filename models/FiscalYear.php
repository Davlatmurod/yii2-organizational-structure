<?php

namespace andahrm\structure\models;

use Yii;

use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
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
class FiscalYear extends \yii\db\ActiveRecord
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
            [['year', 'date_start', 'date_end'], 'required'],
            [['year', 'date_start', 'date_end'], 'safe'],
            [['note'], 'string'],
            [['created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
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
            'year' => Yii::t('andahrm/structure', 'ประจำปี'),
            'date_start' => Yii::t('andahrm/structure', 'เริ่มวันที่'),
            'date_end' => Yii::t('andahrm/structure', 'สิ้นสุดวันที่'),
            'note' => Yii::t('andahrm/structure', 'หมายเหตุ'),
            'created_at' => Yii::t('andahrm/structure', 'Created At'),
            'created_by' => Yii::t('andahrm/structure', 'Created By'),
            'updated_at' => Yii::t('andahrm/structure', 'Updated At'),
            'updated_by' => Yii::t('andahrm/structure', 'Updated By'),
        ];
    }
  
    public function getYearTh(){
      return $this->year+543;
    }
    
    public static function getList(){
      return ArrayHelper::map(self::find()->orderBy(['year'=>SORT_DESC])->all(),'year','yearTh');
    }    
  
    public static function getListSelected(){
       $model = self::find()->all();
      $selected = ArrayHelper::index($model, 'year');
        foreach($selected as $k=>$item){
          $selected[$k]= ['disabled'=>'disabled'];
        }
      return $selected;
    }
  
    public static function getYearAll($start=2000){
      $date_start =  $start;
      $date_end=  date('Y', strtotime("+1 year"));
      return array_combine(range($date_end,$date_start),range($date_end+543,$date_start+543));
    }
  
    public static function currentYear(){
      $toDay = date('Y-m-d');
      $model = self::find()
        ->where(['<=','DATE(date_start)',$toDay])
        ->andWhere(['>=','DATE(date_end)',$toDay])
        ->one();
      //echo $model->year;
      //exit();
      return $model?$model->yearTh:null;
    }
  
  
}
