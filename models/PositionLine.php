<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "position_line".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property integer $person_type_id
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Position $position
 */
class PositionLine extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position_line';
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
    public function rules()
    {
        return [
            [['person_type_id', 'title', 'code'], 'required'],
            [['person_type_id', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['code'], 'string', 'max' => 10],
            [['title'], 'string', 'max' => 255],
            [['person_type_id', 'code'], 'unique', 'targetAttribute' => ['person_type_id', 'code'], 'message' => 'The combination of Person Type ID and Code has already been taken.'],
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
            'person_type_id' => Yii::t('andahrm/structure', 'Person Type'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition()
    {
        return $this->hasOne(Position::className(), ['position_line_id' => 'id']);
    }
  
    public function getPersonType(){
      return $this->hasOne(PersonType::className(), ['id' => 'person_type_id']);
    }
  
     public function getTitleCode(){
      return $this->title."(".$this->code.")";
    }

    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','titleCode');
    }
  
    public static function getListGroup(){
      return ArrayHelper::map(self::find()->all(),'id','titleCode','personType.title');
    }
  
  
    public static function getListByPersonType($person_type_id,$section_id=null){
        $model = self::find()
        ->joinWith('position')
        ->andFilterWhere(['position_line.person_type_id'=>$person_type_id])
        ->andFilterWhere(['position.section_id'=>$section_id])
        ->all();
      return ArrayHelper::map($model,'id','titleCode');
    }
    
    public static function getPositionlines($person_type_id)
    {
        if($person_type_id){
          return ArrayHelper::map(
            self::find()->where([
               'person_type_id'=>$person_type_id
            ])->all()
            ,'id','titleCode');
        }
          return [];
    }
  
  
}
