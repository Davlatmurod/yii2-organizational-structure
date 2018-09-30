<?php

namespace andahrm\structure\models;

use Yii;
use yii\helpers\ArrayHelper;
use andahrm\person\models\Person;
use andahrm\datepicker\behaviors\DateBuddhistBehavior;
use yii\behaviors\TimestampBehavior;
use yii\behaviors\BlameableBehavior;

/**
 * This is the model class for table "president".
 *
 * @property int $user_id
 * @property string $start_date
 * @property string $end_date
 * @property int $status
 * @property string $note
 * @property int $created_at
 * @property int $created_by
 * @property int $updated_at
 * @property int $updated_by
 *
 * @property LeavePresidentApprover[] $leavePresidentApprovers
 */
class President extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'president';
    }

    public function behaviors() {
        return [
            [
                'class' => BlameableBehavior::className(),
            ],
            [
                'class' => TimestampBehavior::className(),
            ],
            'start_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'start_date',
            ],
            'end_date' => [
                'class' => DateBuddhistBehavior::className(),
                'dateAttribute' => 'end_date',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['user_id', 'start_date', 'status'], 'required'],
            [['user_id', 'status', 'created_at', 'created_by', 'updated_at', 'updated_by'], 'integer'],
            [['start_date', 'end_date'], 'safe'],
            [['note'], 'string'],
            [['user_id'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'user_id' => Yii::t('andahrm/structure', 'President User ID'),
            'start_date' => Yii::t('andahrm/structure', 'Start Date'),
            'end_date' => Yii::t('andahrm/structure', 'End Date'),
            'status' => Yii::t('andahrm/structure', 'Status'),
            'note' => Yii::t('andahrm/structure', 'Note'),
            'created_at' => Yii::t('andahrm', 'Created At'),
            'created_by' => Yii::t('andahrm', 'Created By'),
            'updated_at' => Yii::t('andahrm', 'Updated At'),
            'updated_by' => Yii::t('andahrm', 'Updated By'),
        ];
    }

    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    public static function itemsAlias($key) {
        $items = [
            'status' => [
                self::STATUS_NOT_ACTIVE => Yii::t('andahrm/structure', 'President Not Active'),
                self::STATUS_ACTIVE => Yii::t('andahrm/structure', 'President Active'),
            ],
        ];
        return ArrayHelper::getValue($items, $key, []);
    }

    public function getStatusLabel() {
        return ArrayHelper::getValue($this->getItemStatus(), $this->status);
    }

    public static function getItemStatus() {
        return self::itemsAlias('status');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLeavePresidentApprovers() {
        return $this->hasMany(LeavePresidentApprover::className(), ['president_user_id' => 'user_id']);
    }

    public function getPerson() {
        return $this->hasOne(Person::className(), ['user_id' => 'user_id']);
    }

    public static function updateActive($user_id, $start_date) {
        self::updateAll(['status' => self::STATUS_NOT_ACTIVE], ["AND", ['<>', 'user_id', $user_id], ['<>', 'start_date', $start_date]]);
    }

}
