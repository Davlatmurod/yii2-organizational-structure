<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "position_level".
 *
 * @property integer $id
 * @property integer $position_type_id 
 * @property string $title
 * @property integer $note
 * @property integer $created_at
 
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property BaseSalary[] $baseSalaries 
 * @property Position[] $positions
 * @property PositionType $positionType 
 */
class PositionLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position_level';
    }
  
  
    public function behaviors()
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
    public function rules()
    {
        return [
           [['person_type_id', 'position_type_id', 'title','level'], 'required'],
           [['person_type_id','position_type_id', 'note', 'created_at', 'created_by', 'updated_at', 'updated_by','level'], 'integer'],
           [['title'], 'string', 'max' => 50],
           [['position_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionType::className(), 'targetAttribute' => ['position_type_id' => 'id']], 
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/structure', 'ID'),
            'person_type_id' => Yii::t('andahrm/structure', 'Person Type'),
            'position_type_id' => Yii::t('andahrm/structure', 'Position Type'),
            'title' => Yii::t('andahrm/structure', 'Title Level'),
            'titleTypeLevel' => Yii::t('andahrm/structure', 'Title Type Level'),
            'level' => Yii::t('andahrm/structure', 'Level No'),
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
   public function getBaseSalaries() 
   { 
       return $this->hasMany(BaseSalary::className(), ['position_level_id' => 'id']); 
   } 
   
   public function getPersonType(){
      return $this->hasOne(PersonType::className(), ['id' => 'person_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositions()
    {
        return $this->hasMany(Position::className(), ['position_level_id' => 'id']);
    }
  
   /**
    * @return \yii\db\ActiveQuery
    */
   public function getPositionType()
   {
       return $this->hasOne(PositionType::className(), ['id' => 'position_type_id']);
   }
    
    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','title');
    }
    
    public static function getListByPersonType($person_type_id){
      return ArrayHelper::map(self::find()->where(['person_type_id'=>$person_type_id])->all(),'id','title');
    }
    
    public function getTitleTypeLevel()
   {
       return Yii::t('andahrm/structure', 'Title{type}Level{level}',[
           'type'=>$this->positionType->title,
           'level'=>$this->title
           ]);
            
   }
  
  
}
