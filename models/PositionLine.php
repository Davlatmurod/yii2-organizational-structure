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
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/structure', 'รหัส'),
            'code' => Yii::t('andahrm/structure', 'รหัสสายงาน'),
            'title' => Yii::t('andahrm/structure', 'ชื่อสายงาน'),
            'person_type_id' => Yii::t('andahrm/structure', 'ประเภทบุคลากร'),
            'created_at' => Yii::t('andahrm/structure', 'สร้างเมื่อ'),
            'created_by' => Yii::t('andahrm/structure', 'สร้างโดย'),
            'updated_at' => Yii::t('andahrm/structure', 'ปรับปรุงเมื่อ'),
            'updated_by' => Yii::t('andahrm/structure', 'ปรับปรุงโดย'),
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
  
  
}
