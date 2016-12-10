<?php

namespace andahrm\structure\models;

use Yii;

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
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
            [['person_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonType::className(), 'targetAttribute' => ['person_type_id' => 'id']],
            [['position_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionType::className(), 'targetAttribute' => ['position_type_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'person_type_id' => Yii::t('app', 'รหัสประเภทบุคคล'),
            'section_id' => Yii::t('app', 'รหัสกอง'),
            'position_type_id' => Yii::t('app', 'รหัสสายงาน'),
            'number' => Yii::t('app', 'ลำดับ'),
            'name_manage' => Yii::t('app', 'Name Manage'),
            'name_work' => Yii::t('app', 'Name Work'),
            'min_salary' => Yii::t('app', 'Min Salary'),
            'max_salary' => Yii::t('app', 'Max Salary'),
            'note' => Yii::t('app', 'Note'),
        ];
    }
}
