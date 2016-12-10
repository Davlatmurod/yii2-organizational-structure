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
            [['id', 'title'], 'required'],
            [['id', 'level'], 'integer'],
            [['code'], 'string', 'max' => 45],
            [['title', 'leveltype'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'title' => Yii::t('app', 'ชื่อประเภทตำแหน่ง'),
            'level' => Yii::t('app', 'ระดับ'),
            'leveltype' => Yii::t('app', 'Leveltype'),
        ];
    }
}
