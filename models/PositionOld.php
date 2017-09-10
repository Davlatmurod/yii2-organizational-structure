<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use andahrm\positionSalary\models\PersonPositionSalaryOld;

/**
 * This is the model class for table "position_old".
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
 */
class PositionOld extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'position_old';
    }
    
    function behaviors()
    {
        return [ 
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ]
        ];
    }
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['code'], 'string', 'max' => 20],
            [['title'], 'string', 'max' => 100],
            [['note'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/structure', 'ID'),
            'code' => Yii::t('andahrm/structure', 'Code'),
            'title' => Yii::t('andahrm/structure', 'Title'),
            'status' => Yii::t('andahrm/structure', 'Status'),
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm/structure', 'Created At'),
            'created_by' => Yii::t('andahrm/structure', 'Created By'),
            'updated_at' => Yii::t('andahrm/structure', 'Updated At'),
            'updated_by' => Yii::t('andahrm/structure', 'Updated By'),
        ];
    }
    
    public static function getList(){
        return ArrayHelper::map(self::find()->all(),'id','code');
    }
    
    public function getCodeTitle(){
     //return '1';
       return $this->code." ".$this->title;
    }
    
    public function getExists(){
        if(self::find()->where(['code'=>$this->code])->exists()){
            return true;
        }
        return;
    } 
    
    public static function getListTitle(){
      return ArrayHelper::map(self::find()->all(),'id','codeTitle');
    }
}
