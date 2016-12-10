<?php

namespace andahrm\structure\models;

use Yii;

/**
 * This is the model class for table "person_postion".
 *
 * @property integer $user_id
 * @property integer $position_id
 */
class PersonPostion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'person_postion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'position_id'], 'required'],
            [['user_id', 'position_id'], 'integer'],
            [['position_id'], 'exist', 'skipOnError' => true, 'targetClass' => Position::className(), 'targetAttribute' => ['position_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'user_id' => Yii::t('app', 'User ID'),
            'position_id' => Yii::t('app', 'Position ID'),
        ];
    }
}
