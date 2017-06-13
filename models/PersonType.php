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
            [['code', 'title', 'step_max','parent_id'], 'required'],
            [['step_max', 'created_at', 'created_by', 'updated_at', 'updated_by','parent_id','sort'], 'integer'],
            [['code'], 'string', 'max' => 45],
            [['title', 'note'], 'string', 'max' => 255],
            //[['title'], 'unique'],
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
            'parent_id' => Yii::t('andahrm/structure', 'Parent ID'),
            'sort' => Yii::t('andahrm/structure', 'Sort'),
            'code' => Yii::t('andahrm/structure', 'Code'),
            'title' => Yii::t('andahrm/structure', 'Title'),
            'type_gov' => Yii::t('andahrm/structure', 'Goverment Type'),
            'step_max' => Yii::t('andahrm/structure', 'Step Max'), 
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }
    
    const PERSON_GOV = 1;
    const PERSON_SERVENT = 4;
    const PERSON_EMPLOYEE = 8;
    const PERSON_TRANSFER = 8;
    const PERSON_HEADER = 13;

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

    public static function getList($group = true,$parint_id=null){
      $modelParent = self::find()->where(['=','parent_id','0'])
                    ->select(['id'])
                    ->orderBy(['sort'=>SORT_ASC])
                    ->asArray()->all();
      $modelParent = ArrayHelper::getColumn($modelParent,'id');
      $sortField = implode(',', $modelParent);
      $model = self::find()->where(['parent_id'=>$modelParent])
          ->andFilterWhere(['parent_id'=>$parint_id])
          ->orderBy([new \yii\db\Expression('FIELD (parent_id, ' . $sortField . ')')])
          ->all();

      if($group)
      return ArrayHelper::map($model,'id','titleCode','parent.title');
      return ArrayHelper::map($model,'id','titleCode');
    }
    
    public static function getParentList($root = true){
      $model =  ArrayHelper::map(self::find()->where(['parent_id'=>'0'])->orderBy(['sort'=>SORT_ASC])->all(),'id','title');
      if($root)
      return ArrayHelper::merge([0=>Yii::t('andahrm/structure','Root')],$model);
      return $model;
    }
    
    # For Insignia
    public static function getForInsignia(){
      $model = self::find()->where(['id'=>[8,9,1,2,3,4]])->all();
      return ArrayHelper::map($model,'id','title');
    }
    
    public function getParent(){ 
       return $this->hasOne(self::className(), ['id' => 'parent_id']); 
   }
  
  
  
}
