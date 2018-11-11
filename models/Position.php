<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;
use yii\behaviors\AttributeBehavior;
use yii\db\ActiveRecord;
use andahrm\person\models\Person;
use andahrm\positionSalary\models\PersonPositionSalary;

/**
 * This is the model class for table "position".
 *
 * @property integer $id
 * @property integer $person_type_id
 * @property integer $section_id
 * @property integer $position_line_id
 * @property integer $number
 * @property string $title
 * @property integer $position_type_id
 * @property integer $position_level_id
 * @property integer $min_salary
 * @property integer $max_salary
 * @property string $note
 * @property integer $created_at
 * @property integer $created_by
 * @property integer $updated_at
 * @property integer $updated_by
 *
 * @property PersonPostion[] $personPostions
 * @property Person[] $users
 * @property PositionLevel $positionLevel
 * @property PositionLine $positionLine
 * @property PersonType $personType
 * @property PositionType $positionType
 * @property Section $section
 */
class Position extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'position';
    }

    function behaviors() {
        return [
            'timestamp' => [
                'class' => TimestampBehavior::className(),
            ],
            'blameable' => [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => 'mdm\autonumber\Behavior',
                'attribute' => 'number', // required
                'group' => $this->person_type_id . '-' . $this->section_id . ($this->position_line_id ? '-' . $this->position_line_id : ''), // optional
                'value' => '?', // format auto number. '?' will be replaced with generated number
            //'digit' => 4 // optional, default to null. 
            ],
                // [
                //     'class' => AttributeBehavior::className(),
                //     'attributes' => [
                //         ActiveRecord::EVENT_BEFORE_INSERT => 'rate_date',
                //         ActiveRecord::EVENT_BEFORE_UPDATE => 'rate_date',
                //     ],
                //     'value' => function ($event) {
                //          $this->rate_date = $this->rate_date?$this->rate_date-543:null;
                //         //  echo $this->rate_date;
                //         //  exit();
                //          return $this->rate_date;
                //     },
                // ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            //[['person_type_id', 'section_id', 'position_line_id', 'title', 'position_type_id'], 'required'],
            [['person_type_id', 'section_id', 'title', 'code'], 'required'],
            [['person_type_id', 'section_id', 'position_line_id', 'number', 'position_type_id', 'position_level_id', 'min_salary', 'max_salary', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['note'], 'string', 'max' => 255],
            [['code'], 'string', 'max' => 20],
            //[[ 'number'], 'unique', 'targetAttribute' => ['person_type_id', 'section_id', 'position_line_id', 'number'], 'message' => 'The combination of Person Type ID, Section ID, Position Line ID and Number has already been taken.'],
            [['position_level_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionLevel::className(), 'targetAttribute' => ['position_level_id' => 'id']],
            [['position_line_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionLine::className(), 'targetAttribute' => ['position_line_id' => 'id']],
            [['person_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PersonType::className(), 'targetAttribute' => ['person_type_id' => 'id']],
            [['position_type_id'], 'exist', 'skipOnError' => true, 'targetClass' => PositionType::className(), 'targetAttribute' => ['position_type_id' => 'id']],
            [['section_id'], 'exist', 'skipOnError' => true, 'targetClass' => Section::className(), 'targetAttribute' => ['section_id' => 'id']],
            ['number', 'unique', 'targetAttribute' => ['person_type_id', 'section_id', 'position_line_id', 'number'], 'message' => 'ลำดับนี้มีอยู่แล้ว'],
            [['code', 'open_date', 'close_date'], 'safe'],
            [['code'], 'unique'],
            [['status'], 'default', 'value' => 1],
        ];
    }

    public function scenarios() {
        $scenarios = parent::scenarios();

        $scenarios['insert'] = ['code', 'title', 'person_type_id', 'section_id', 'position_line_id', 'number', 'position_type_id', 'position_level_id', 'min_salary', 'max_salary', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'open_date', 'close_date'];

        $scenarios['update'] = ['code', 'title', 'person_type_id', 'section_id', 'position_line_id', 'number', 'position_type_id', 'position_level_id', 'min_salary', 'max_salary', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by', 'open_date', 'close_date'];

        $scenarios['update-status'] = ['status', 'updated_at', 'updated_by', 'open_date', 'close_date'];

        $scenarios['search'] = ['section_id'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('andahrm/structure', 'ID'),
            'person_type_id' => Yii::t('andahrm/structure', 'Person Type'),
            'section_id' => Yii::t('andahrm/structure', 'Section'),
            'position_line_id' => Yii::t('andahrm/structure', 'Position Line'),
            'number' => Yii::t('andahrm/structure', 'Number'),
            'title' => Yii::t('andahrm/structure', 'Title'),
            'position_type_id' => Yii::t('andahrm/structure', 'Position Type'),
            'position_level_id' => Yii::t('andahrm/structure', 'Position Level'),
            'min_salary' => Yii::t('andahrm/structure', 'Min Salary'),
            'max_salary' => Yii::t('andahrm/structure', 'Max Salary'),
            //'rate_date' => Yii::t('andahrm/structure', 'Rate Date'),
            'open_date' => Yii::t('andahrm/structure', 'Open Date'),
            'close_date' => Yii::t('andahrm/structure', 'Close Date'),
            'status' => Yii::t('andahrm/structure', 'Status'),
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
            'code' => Yii::t('andahrm/structure', 'Code Position'),
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeHints() {
        return [
            'number' => Yii::t('andahrm/structure', '001 type 1 or empty'),
        ];
    }

    const STASUS_CLOSE = 0;
    const STASUS_FREE = 1;
    const STASUS_USED = 2;

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                self::STASUS_CLOSE => Yii::t('andahrm/structure', 'Close'),
                self::STASUS_FREE => Yii::t('andahrm/structure', 'Free'),
                self::STASUS_USED => Yii::t('andahrm/structure', 'Used'),
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        $status = ArrayHelper::getValue($this->getItemStatus(), $this->status);
        $status = ($this->status === NULL) ? ArrayHelper::getValue($this->getItemStatus(), 0) : $status;
        switch ($this->status) {
            case 0 :
            case NULL :
                $str = '<span class="label label-danger">' . $status . '</span>';
                break;
            case 1 :
                $str = '<span class="label label-warning">' . $status . '</span>';
                break;
            case 2 :
                $str = '<span class="label label-success">' . $status . '</span>';
                break;
            default :
                $str = $status;
                break;
        }

        return $str;
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonPositionSalaries() {
        return $this->hasMany(PersonPositionSalary::className(), ['position_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonPositionSalary() {
        return $this->hasOne(PersonPositionSalary::className(), ['position_id' => 'id'])->orderBy(['adjust_date' => SORT_DESC]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers() {
        return $this->hasMany(Person::className(), ['user_id' => 'user_id'])->viaTable('person_position_salary', ['position_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser() {
        return $this->hasOne(Person::className(), ['position_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionLevel() {
        return $this->hasOne(PositionLevel::className(), ['id' => 'position_level_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionLine() {
        return $this->hasOne(PositionLine::className(), ['id' => 'position_line_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPerson() {
        return $this->hasOne(Person::className(), ['position_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersons() {
        return $this->hasMany(Person::className(), ['position_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPersonType() {
        return $this->hasOne(PersonType::className(), ['id' => 'person_type_id']);
    }

    public function getPersonTypeTitle() {
        return $this->personType->title;
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPositionType() {
        return $this->hasOne(PositionType::className(), ['id' => 'position_type_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSection() {
        return $this->hasOne(Section::className(), ['id' => 'section_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStructurePositions() {
        return $this->hasMany(StructurePosition::className(), ['position_id' => 'id']);
    }

    public function getGeneratCode() {
        //return '1';
        return $this->personType->code
                . '-' . $this->section->code
                . ($this->positionLine ? '-' . $this->positionLine->code : '')
                . '-' . sprintf("%03d", $this->number);
        //return $this->personType->code.'-'.$this->section->code.'-'.$this->positionType->code.'-'.str_pad($this->number, 4, '0', STR_PAD_LEFT);
    }

    public function getCodeTitle() {
        //return '1';
        return $this->code . " " . $this->title;
    }

    public function getTitleCode() {
        return $this->title . "<br/><small>" . $this->code . "</small>";
    }

    public static function getList($id = null) {
        $model = self::find()->andFilterWhere(['id' => $id])->limit(20)->all();
        return ArrayHelper::map($model, 'id', 'code');
    }

    public static function getListTitle() {
        return ArrayHelper::map(self::find()->limit(20)->all(), 'id', 'codeTitle');
    }

    public static function getListProp() {
        $res = [];
        foreach (self::find()->all() as $item) {
            $res[$item->id] = [
                'type' => $item->personType->title,
                'section' => $item->section->title,
                'positionLine' => $item->positionLine->title,
                'code' => $item->code,
                'title' => $item->title,
            ];
        }
        return $res;
    }

    public function getStructurePosition($structure_id) {
        return StructurePosition::find()->where(['position_id' => $this->id, 'structure_id' => $structure_id])->count();
    }

//   public static function getPositionlines($person_type_id)
//     {
//         if($person_type_id){
//           return ArrayHelper::map(
//             PositionLine::find()->where([
//               'person_type_id'=>$person_type_id
//             ])->all()
//             ,'id','title');
//         }
//           return [];
//     }


    public function getUserLast() {
        return $this->users[0];
    }

    public static function getListByPersonType($person_type_id) {
        return ArrayHelper::map(self::find()->where(['person_type_id' => $person_type_id])->all(), 'id', 'title');
    }

    public function getExists() {
        if (self::find()->where(['person_type_id' => $this->person_type_id, 'section_id' => $this->section_id, 'number' => (int) $this->number])->andFilterWhere(['position_line_id' => $this->position_line_id])->exists()) {
            return true;
        }
        return;
    }

    public function getCreatedBy() {
        return $this->hasOne(Person::className(), ['user_id' => 'created_by']);
    }

    public function getUpdatedBy() {
        return $this->hasOne(Person::className(), ['user_id' => 'updated_by']);
    }

    public $count;

    public function getTitleLevel() {
        return $this->title . ($this->position_level_id ? ' ' . $this->positionLevel->title : '');
    }

    public function getCloseDateBtn() {

        if ($this->close_date) {
            return Yii::$app->formatter->asDate($this->close_date);
        } else {
            $btn = \yii\helpers\Html::a(Yii::t('andahrm/structure', 'Close'), ['#'], ['class' => 'btn btn-warning']);
            return $btn;
        }
    }

    public static function myList($user_id) {
        $model = self::find()->joinWith('personPositionSalary')->where(['user_id' => $user_id])->distinct('id')->all();
        return ArrayHelper::map($model, 'id', 'codeTitle');
    }

}
