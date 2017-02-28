<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
* This is the model class for table "person_type".
 
* @property integer $id
* @property string $code
* @property string $title
* @property integer $step_max 
* @property string $note
* @property integer $created_at
* @property integer $created_by
* @property integer $updated_at
* @property integer $updated_by
*
* @property BaseSalary[] $baseSalaries 
* @property Position[] $positions
* @property PositionLine[] $positionLines
* @property PositionType[] $positionTypes 
*/
class PersonType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code', 'title', 'step_max'], 'required'],
            [['step_max', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['code'], 'string', 'max' => 45],
            [['title', 'note'], 'string', 'max' => 255],
            [['title'], 'unique'],
            //[['code'], 'unique'],
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
            'code' => Yii::t('andahrm/structure', 'Code'),
            'title' => Yii::t('andahrm/structure', 'Title'),
            'step_max' => Yii::t('andahrm/structure', 'Step Max'), 
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
    public function getPositions()
    {
        return $this->hasMany(Position::className(), ['person_type_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionLines()
    {
        return $this->hasMany(PositionLine::className(), ['person_type_id' => 'id']);
    }
  
    /** 
    * @return \yii\db\ActiveQuery 
    */ 
   public function getBaseSalaries() 
   { 
       return $this->hasMany(BaseSalary::className(), ['person_type_id' => 'id']); 
   }
  
  /**
    * @return \yii\db\ActiveQuery
    */
   public function getPositionTypes()
   {
       return $this->hasMany(PositionType::className(), ['person_type_id' => 'id']);
   }
  
    public function getTitleCode(){
      return $this->title." (".$this->code.")";
    }

    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','titleCode');
    }
    
    # For Insignia
    public static function getForInsignia(){
      $model = self::find()->where(['id'=>[8,9,1,2,3,4]])->all();
      return ArrayHelper::map($model,'id','title');
    }
  
  
}
