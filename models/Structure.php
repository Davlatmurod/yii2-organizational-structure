<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use wbraganca\behaviors\NestedSetBehavior;
use wbraganca\behaviors\NestedSetQuery;

/**
 * This is the model class for table "structure".
 *
 * @property integer $id
 * @property integer $root
 * @property integer $lft
 * @property integer $rgt
 * @property integer $level
 * @property integer $section_id
 * @property integer $position_line_id
 * @property string $title
 * @property integer $status
 * @property string $note
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 */
class Structure extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'structure';
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
            'nestedsets' => [
                'class' => NestedSetBehavior::className(),
                // 'rootAttribute' => 'root',
                // 'levelAttribute' => 'level',
                // 'hasManyRoots' => true
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['root', 'lft', 'rgt', 'level', 'section_id', 'position_line_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['section_id', 'position_line_id', 'title'], 'required'],
            [['note'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }
  
  public static function find()
    {
        return new NestedSetQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('andahrm/structure', 'รหัสกอง'),
            'root' => Yii::t('andahrm/structure', 'Root'),
            'lft' => Yii::t('andahrm/structure', 'Lft'),
            'rgt' => Yii::t('andahrm/structure', 'Rgt'),
            'level' => Yii::t('andahrm/structure', 'Level'),
            'section_id' => Yii::t('andahrm/structure', 'รหัสกอง'),
            'position_line_id' => Yii::t('andahrm/structure', 'ตำแหน่งในสายงาน'),
            'title' => Yii::t('andahrm/structure', 'ชื่อกอง'),
            'status' => Yii::t('andahrm/structure', 'Status'),
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm/structure', 'Created At'),
            'created_by' => Yii::t('andahrm/structure', 'Created By'),
            'updated_at' => Yii::t('andahrm/structure', 'Updated At'),
            'updated_by' => Yii::t('andahrm/structure', 'Updated By'),
        ];
    }
  
   public static function getOrg($id=null){
     $model = self::find()->dataFancytree();
     $org = $model[0];
     
     $str = '<ul id="organisation">';
     $str .='<li>'.$org['title'];
     $str .= self::getOrgSub($org['children'],$model);
     $str .= '</ul>';
     return $str;
   }
  
  public static function getOrgSub($sub,$parent = null){   
        if ($sub) {
          
          if(isset($parent)){
            $parent['start'] = '';
            $parent['end'] = '';
          }
          
            $str = '';
            $str .= $parent['start'];
            $str .= '<ul>';
            foreach ($sub as $org) {
                $str .= '<li>';
                $str .= '<a href="#" id="head">'. $org['title'] . '</a>';               
                $str .= isset($org['children'])?self::getOrgSub($org['children'], $parent):''; 
                $str .= '</li>';
            }
            $str .= '</ul>';
            $str .= $parent['end'];
            return $str;
        }elseif($parent){
            $str = $parent?$parent['start'].$parent['end']:'';
            return $str;
        }
        return false;
     
   }
  
  
}
