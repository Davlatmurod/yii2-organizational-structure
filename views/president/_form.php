<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\widgets\Select2;
use yii\web\JsExpression;
use andahrm\person\models\Person;
use andahrm\datepicker\DatePicker;
use andahrm\setting\models\WidgetSettings;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\President */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="president-form">

    <?php $form = ActiveForm::begin(); ?>



    <?=
    $form->field($model, 'user_id', [
            //'inputTemplate' => $positionInputTemplate,
            //'options' => ['class' => 'form-group col-sm-6']
    ])->widget(Select2::classname(), [
        //'data' => Position::getList($models->position_id),
        'data' => Person::getList($model->user_id),
        'options' => ['placeholder' => Yii::t('andahrm/person', 'Search for a position')],
        'pluginOptions' => [
            //'tags' => true,
            //'tokenSeparators' => [',', ' '],
            'allowClear' => true,
            'minimumInputLength' => 2, //ต้องพิมพ์อย่างน้อย 3 อักษร ajax จึงจะทำงาน
            'ajax' => [
                'url' => Url::to(['/person/default/person-list']),
                'dataType' => 'json', //รูปแบบการอ่านคือ json
                'data' => new JsExpression('function(params) { return {q:params.term};}')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(position) { return position.text; }'),
            'templateSelection' => new JsExpression('function (position) { return position.text; }'),
        ],
            ]
    )->hint(false);
    ?>

    <?=
            $form->field($model, "start_date")
            ->widget(DatePicker::classname(), WidgetSettings::DatePicker());
    ?>

    <?= $form->field($model, 'end_date')->textInput() ?>

    <?= $form->field($model, 'status')->checkbox(['label' => 'ปัจจุบันยังรักษาการอยู่']) ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm/structure', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
