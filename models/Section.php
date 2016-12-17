<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "section".
 *
 * @property integer $id
 * @property string $code
 * @property string $title
 * @property integer $status
 * @property string $note
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property Position[] $positions
 */
class Section extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'section';
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
            [['title'], 'required'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['note'], 'string'],
            [['code'], 'string', 'max' => 4],
            [['title'], 'string', 'max' => 255],
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
            'id' => Yii::t('andahrm/structure', 'รหัสกอง'),
            'code' => Yii::t('andahrm/structure', 'รหัสกอง'),
            'title' => Yii::t('andahrm/structure', 'ชื่อกอง'),
            'status' => Yii::t('andahrm/structure', 'Status'),
            'note' => Yii::t('andahrm/structure', 'Note'),
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
        return $this->hasMany(Position::className(), ['section_id' => 'id']);
    }
  
  
   public function getTitleCode(){
      return $this->title."(".$this->code.")";
    }

    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','titleCode');
    }
  
}
