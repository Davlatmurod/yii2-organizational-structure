<?php

namespace andahrm\structure\models;

use Yii;

/**
 * This is the model class for table "position_type".
 *
 * @property integer $id
 * @property string $title
 * @property string $code
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
            [['id'], 'required'],
            [['id'], 'integer'],
            [['title'], 'string', 'max' => 50],
            [['code'], 'string', 'max' => 45],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'รหัสตำแหน่งในแต่ละกอง'),
            'title' => Yii::t('app', 'ชื่อตำแหน่งในแต่ละกอง'),
            'code' => Yii::t('app', 'Code'),
        ];
    }
}
