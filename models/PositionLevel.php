<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "position_level".
 *
 * @property integer $id
 * @property string $title
 * @property integer $note
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Position[] $positions
 */
class PositionLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position_level';
    }
  
  
    public function behaviors()
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
            [['note', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 50],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/structure', 'รหัส'),
            'title' => Yii::t('andahrm/structure', 'ระดับตำแหน่ง'),
            'note' => Yii::t('andahrm/structure', 'หมายเหตุ'),
            'created_at' => Yii::t('andahrm/structure', 'Created At'),
            'created_by' => Yii::t('andahrm/structure', 'Created By'),
            'updated_at' => Yii::t('andahrm/structure', 'Updated At'),
            'updated_by' => Yii::t('andahrm/structure', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositions()
    {
        return $this->hasMany(Position::className(), ['position_level_id' => 'id']);
    }
  
  
    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','title');
    }
}
