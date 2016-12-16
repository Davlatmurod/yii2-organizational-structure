<?php

namespace andahrm\structure\models;

use Yii;

/**
 * This is the model class for table "position_type".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 */
class PositionType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
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
            'id' => Yii::t('andahrm/personType', 'รหัส'),
            'code' => Yii::t('andahrm/personType', 'รหัสสายงาน'),
            'title' => Yii::t('andahrm/personType', 'ชื่อสายงาน'),
        ];
    }
}
