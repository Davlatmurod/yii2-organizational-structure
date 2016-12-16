<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "position".
 *
 * @property integer $id
 * @property integer $person_type_id
 * @property integer $section_id
 * @property integer $position_type_id
 * @property integer $number
 * @property string $name_manage
 * @property string $name_work
 * @property integer $min_salary
 * @property integer $max_salary
 * @property string $note
 *
 * @property PersonPostion[] $personPostions
 * @property Person[] $users
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'person_type_id', 'section_id', 'position_type_id', 'number'], 'required'],
            [['id', 'person_type_id', 'section_id', 'position_type_id', 'number', 'min_salary', 'max_salary'], 'integer'],
            [['name_manage', 'name_work'], 'string', 'max' => 50],
            [['note'], 'string', 'max' => 255],
            [['person_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonType::className(), 'targetAttribute' => ['person_type_id' => 'id']],
            [['position_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionType::className(), 'targetAttribute' => ['position_type_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['code'],'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/personType', 'ID'),
            'person_type_id' => Yii::t('andahrm/personType', 'รหัสประเภทบุคคล'),
            'section_id' => Yii::t('andahrm/personType', 'รหัสกอง'),
            'position_type_id' => Yii::t('andahrm/personType', 'รหัสสายงาน'),
            'number' => Yii::t('andahrm/personType', 'ลำดับ'),
            'name_manage' => Yii::t('andahrm/personType', 'Name Manage'),
            'name_work' => Yii::t('andahrm/personType', 'Name Work'),
            'min_salary' => Yii::t('andahrm/personType', 'Min Salary'),
            'max_salary' => Yii::t('andahrm/personType', 'Max Salary'),
            'note' => Yii::t('andahrm/personType', 'Note'),
            'code' => Yii::t('andahrm/personType', 'Code'),
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
    
    public function getCode(){
       return $this->personType->code.'-'.$this->section->code.'-'.$this->positionType->code.'-'.sprintf("%03d",$this->number);
      //return $this->personType->code.'-'.$this->section->code.'-'.$this->positionType->code.'-'.str_pad($this->number, 4, '0', STR_PAD_LEFT);
    }
  
    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','code');
    }
  
}
