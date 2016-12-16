<?php

namespace andahrm\structure\models;

use Yii;

/**
 * This is the model class for table "person_type".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property integer $level
 * @property string $leveltype
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
            [['title'], 'required'],
            [['level'], 'integer'],
            [['code'], 'string', 'max' => 45],
            [['title', 'leveltype'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/personType', 'ID'),
            'code' => Yii::t('andahrm/personType', 'รหัส'),
            'title' => Yii::t('andahrm/personType', 'ชื่อประเภทตำแหน่ง'),
            'level' => Yii::t('andahrm/personType', 'ระดับ'),
            'leveltype' => Yii::t('andahrm/personType', 'Leveltype'),
        ];
    }
}
