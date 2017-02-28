<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
/**
 * This is the model class for table "position_type".
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
class PositionType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position_type';
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
            [['note', 'created_at', 'created_by', 'updated_at', 'updated_by','person_type_id'], 'integer'],
            [['title','note'], 'string', 'max' => 255],
            //[['title'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/structure', 'ID'),
            'person_type_id' => Yii::t('andahrm/structure', 'Person Type'),
            'title' => Yii::t('andahrm/structure', 'Title'),
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositions()
    {
        return $this->hasMany(Position::className(), ['position_type_id' => 'id']);
    }
  
  /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonType()
    {
        return $this->hasOne(PersonType::className(), ['id' => 'person_type_id']);
    }
  
    public static function getList(){
      return ArrayHelper::map(self::find()->all(),'id','title');
    }
  
    public static function getListGroup(){
      return ArrayHelper::map(self::find()->all(),'id','title','personType.title');
    }
    
  
}
