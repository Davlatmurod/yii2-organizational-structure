<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\Html;
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
class Structure extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'structure';
    }

    function behaviors() {
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
    public function rules() {
        return [
            [['root', 'lft', 'rgt', 'level', 'section_id', 'position_line_id', 'person_type_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'previous'], 'integer'],
            [['section_id', 'position_line_id', 'title'], 'required'],
            [['note'], 'string'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    public $person_type_id;
    public $previous;

    public static function find() {
        return new NestedSetQuery(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('andahrm/structure', 'ID'),
            'root' => Yii::t('andahrm/structure', 'Root'),
            'lft' => Yii::t('andahrm/structure', 'Lft'),
            'rgt' => Yii::t('andahrm/structure', 'Rgt'),
            'level' => Yii::t('andahrm/structure', 'Level'),
            'section_id' => Yii::t('andahrm/structure', 'Section'),
            'position_line_id' => Yii::t('andahrm/structure', 'Position Line'),
            'title' => Yii::t('andahrm/structure', 'Title Structure'),
            'status' => Yii::t('andahrm/structure', 'Status'),
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
            'previous' => Yii::t('andahrm/structure', 'Previous'),
            'person_type_id' => Yii::t('andahrm/structure', 'Person Type'),
        ];
    }

    public static function getOrg($id = null) {
        $model = self::find()->dataFancytree();
        $org = $model[0];

        $str = '<ul id="organisation" style="display:none;">';
        $str .= '<li>' . $org['title'];
        $str .= self::getOrgSub($org['children'], $model);
        $str .= '</ul>';
        return $str;
    }

    public static function getOrgSub($sub, $parent = null) {
        if ($sub) {

            if (isset($parent)) {
                $parent['start'] = '';
                $parent['end'] = '';
            }

            $str = '';
            $str .= $parent['start'];
            $str .= '<ul>';
            foreach ($sub as $org) {
                $str .= '<li>';
                $str .= $org['title'];
                $str .= isset($org['children']) ? self::getOrgSub($org['children'], $parent) : '';
                $str .= '</li>';
            }
            $str .= '</ul>';
            $str .= $parent['end'];
            return $str;
        } elseif ($parent) {
            $str = $parent ? $parent['start'] . $parent['end'] : '';
            return $str;
        }
        return false;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStructurePosition() {
        return $this->hasOne(StructurePosition::className(), ['structure_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStructurePositions() {
        return $this->hasMany(StructurePosition::className(), ['structure_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPosition() {
        return $this->structurePosition ? $this->structurePosition->position : null;
    }

    public static function getOrgJson($id = null) {
        $model = self::findOne(['level' => 1]);
        $num = 1;
//        echo '<pre>';
//        print_r($model->children()->all());
//        exit();
        $str = [
            'name' => $model->title,
            'title' => ($model->structurePosition && $model->structurePosition->user) ? $model->structurePosition->user
                    ->getInfoMedia('#', [
                        'wrapper' => true,
                        'wrapperTag' => 'div'
                    ]) : $model->getEmptyPosition($model),
            'children' => self::getOrgSubJson($model->children()->all(), $num),
            'className' => 'first-level',
        ];
        return $str;
    }

    public static function getOrgSubJson($parent, $num) {
        if ($parent) {
            $str = [];
            $user = [];
            $num += 1;
            $index = 1;
            if ($num == 2) {
                foreach ($parent as $model) {

                    $user = [];
                    //  echo $model->id;
                    //   echo count($model->structurePositions);
                    //   exit();
                    //  echo "<pre>";
                    //  print_r($model->structurePositions[0]->positions);
                    //  exit();
                    //if(isset($model->position) && isset($model->position->users)){
                    // echo count($model->structurePositions);
                    //  echo "\n"; echo "\n";
//                    foreach ($model->structurePositions as $struture) {
//                        //$user=[];
//                        foreach ($struture->positions as $position) {
//                            if ($position->users) {
//                                foreach ($position->users as $u) {
//                                    if (isset($u)) {
//                                        $user[] = $u->getInfoMedia('#', [
//                                            'wrapper' => true,
//                                            'wrapperTag' => 'div'
//                                        ]);
//                                    }
//                                }
//                            } else {
//                                $user[] = $model->getEmptyPosition($struture);
//                            }
//                        }
//
//                    }
                    foreach ($model->structurePositions as $struture) {
                        //$user=[];
                        if ($struture->users) {
//                            if ($struture->struture_id == 222) {
//                                echo "<pre>";
//                                print_r($struture->users);
//                                exit();
//                            }
                            foreach ($struture->users as $u) {

//                                foreach ($position->users as $u) {
                                if (isset($u)) {
                                    $user[] = $u->getInfoMedia(['/person/default/view', 'id' => $u->user_id], [
                                        'wrapper' => true,
                                        'wrapperTag' => 'div'
                                    ]);
                                }
//                                }
                            }
                        } else {
                            $user[] = $model->getEmptyPosition($struture);
                        }
                    }

                    $str[] = [
                        'name' => Html::a($model->title, ['index', 'id' => $model->id], ['data-pjax' => 0]),
                        'title' => $user ? implode("", $user) : $model->getEmptyPosition($model),
                        'children' => self::getOrgSubJson($model->children()->all(), $num),
                        'className' => 'child-level-' . $num . ' index-' . ($index++),
                    ];
                }
            } else {
                foreach ($parent as $model) {

                    $user = [];

//                    if (isset($model->position) && isset($model->position->users)) {
//                        foreach ($model->position->users as $u) {
//                            $user[] = $u->getInfoMedia('#', [
//                                'wrapper' => true,
//                                'wrapperTag' => 'div'
//                            ]);
//                        }
//                    }
                    foreach ($model->structurePositions as $struture) {
                        if (isset($struture->users)) {
                            foreach ($struture->users as $u) {
                                $user[] = $u->getInfoMedia(['/person/default/view', 'id' => $u->user_id], [
                                    'wrapper' => true,
                                    'wrapperTag' => 'div'
                                ]);
                            }
                        }
                    }
                    $str[] = [
                        'name' => Html::a($model->title, ['index', 'id' => $model->id], ['data-pjax' => 0]),
                        'title' => $user ? implode("", $user) : $model->getEmptyPosition($model),
                        'children' => self::getOrgSubJson($model->children()->all(), $num),
                        'className' => 'child-level-' . $num . ' index-' . ($index++),
                    ];
                }
            }

            return $str;
        }
        return null;
    }

    public function getEmptyPosition($modelPosition = null) {
        $title = isset($modelPosition->position) ? $modelPosition->position->title : null;
        return '<div class="media event"><div class="media-body"><a class="title" href="#">ว่าง</a>
            <p class="position">' . $title . '</p></div><div class="clearfix"></div></div>';
    }

}
