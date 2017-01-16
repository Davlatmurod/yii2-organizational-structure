<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "position".
 *
 * @property integer $id
 * @property integer $person_type_id
 * @property integer $section_id
 * @property integer $position_line_id
 * @property integer $number
 * @property string $title
 * @property integer $position_type_id
 * @property integer $position_level_id
 * @property integer $min_salary
 * @property integer $max_salary
 * @property string $note
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property PersonPostion[] $personPostions
 * @property Person[] $users
 * @property PositionLevel $positionLevel
 * @property PositionLine $positionLine
 * @property PersonType $personType
 * @property PositionType $positionType
 * @property Section $section
 */
class Position extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position';
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
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'number', // required
                'group' => $this->person_type_id+$this->section_id+$this->position_line_id, // optional
                'value' => '?' , // format auto number. '?' will be replaced with generated number
                //'digit' => 4 // optional, default to null. 
            ],
        ];
    }


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['person_type_id', 'section_id', 'position_line_id', 'title', 'position_type_id'], 'required'],
            [['person_type_id', 'section_id', 'position_line_id', 'title', 'position_type_id'], 'required'],
            [['person_type_id', 'section_id', 'position_line_id', 'number', 'position_type_id', 'position_level_id', 'min_salary', 'max_salary', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['note'], 'string', 'max' => 255],
            [['person_type_id', 'section_id', 'position_type_id', 'number'], 'unique', 'targetAttribute' => ['person_type_id', 'section_id', 'position_type_id', 'number'], 'message' => 'The combination of รหัสประเภทบุคคล, รหัสกอง, ลำดับ and ประเภทตำแหน่ง has already been taken.'],
            [['position_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionLevel::className(), 'targetAttribute' => ['position_level_id' => 'id']],
            [['position_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionLine::className(), 'targetAttribute' => ['position_line_id' => 'id']],
            [['person_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonType::className(), 'targetAttribute' => ['person_type_id' => 'id']],
            [['position_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionType::className(), 'targetAttribute' => ['position_type_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
          ['number', 'unique', 'targetAttribute' => ['person_type_id', 'section_id', 'position_type_id', 'number'] ,'message'=>'ลำดับนี้มีอยู่แล้ว'],
            [['code'],'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/structure', 'ID'),
            'person_type_id' => Yii::t('andahrm/structure', 'รหัสประเภทบุคคล'),
            'section_id' => Yii::t('andahrm/structure', 'รหัสกอง'),
            'position_line_id' => Yii::t('andahrm/structure', 'ตำแหน่งในสายงาน'),
            'number' => Yii::t('andahrm/structure', 'ลำดับ'),
            'title' => Yii::t('andahrm/structure', 'ชื่อตำแหน่งในงานบริหาร'),
            'position_type_id' => Yii::t('andahrm/structure', 'ประเภทตำแหน่ง'),
            'position_level_id' => Yii::t('andahrm/structure', 'ระดับตำแหน่ง'),
            'min_salary' => Yii::t('andahrm/structure', 'เงินเดือนตำ่สุด'),
            'max_salary' => Yii::t('andahrm/structure', 'เงินเดือนสูงสุด'),
            'note' => Yii::t('andahrm/structure', 'หมายเหตุ'),
            'created_at' => Yii::t('andahrm/structure', 'สร้างเมื่อ'),
            'created_by' => Yii::t('andahrm/structure', 'สร้างโดย'),
            'updated_at' => Yii::t('andahrm/structure', 'ปรับปรุงเมื่อ'),
            'updated_by' => Yii::t('andahrm/structure', 'ปรับปรุงโดย'),
            'code' => Yii::t('andahrm/structure', 'Code Position'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonPostions()
    {
        return $this->hasMany(PersonPostion::className(), ['position_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Person::className(), ['user_id' => 'user_id'])->viaTable('person_postion', ['position_id' => 'id']);
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
    public function getPositionLine()
    {
        return $this->hasOne(PositionLine::className(), ['id' => 'position_line_id']);
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection()
    {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }
  
  /**
    * @return \yii\db\ActiveQuery
    */
   public function getStructurePositions()
   {
       return $this->hasMany(StructurePosition::className(), ['position_id' => 'id']);
   }
    
  
   public function getCode(){
     //return '1';
       return $this->personType->code
         .'-'.$this->section->code
         .'-'.$this->positionLine->code
         .'-'.sprintf("%03d",$this->number);
      //return $this->personType->code.'-'.$this->section->code.'-'.$this->positionType->code.'-'.str_pad($this->number, 4, '0', STR_PAD_LEFT);
    }
  
    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','code');
    }
  
  
  public function getStructurePosition($structure_id)
   {
       return StructurePosition::find()->where(['position_id'=>$this->id,'structure_id'=>$structure_id])->count();
   }
  
   public static function getPositionlines($person_type_id)
    {
        if($person_type_id){
          return ArrayHelper::map(
            PositionLine::find()->where([
               'person_type_id'=>$person_type_id
            ])->all()
            ,'id','title');
        }
          return [];
    }
      
  
}
