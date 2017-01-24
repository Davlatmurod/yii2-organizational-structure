<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\widgets\DatePicker;

use andahrm\structure\models\FiscalYear;
/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\FiscalYear */
/* @var $form yii\widgets\ActiveForm */
//print_r(FiscalYear::getListSelected());
//exit();
?>

<div class="fiscal-year-form">

    <?php $form = ActiveForm::begin(); ?>

  <div class="row">
    <div class="col-sm-4">
      <?php if($model->isNewRecord):?>
      <?= $form->field($model, 'year')->dropDownList(FiscalYear::getYearAll(),[
      'options'=>FiscalYear::getListSelected()
    ]) ?>
      <?php else:?>
      <?=Html::tag('h2',$model->yearTh)?>
      <?php endif;?>
    </div>
  </div>
  
  
  <div class="row">
    <div class="col-sm-12">
      <?php
      $layout3 = <<< HTML
    <span class="input-group-addon">ตั้งแต่วันที่</span>
    {input1}
    <span class="input-group-addon">ถึงวันที่</span>
    {input2}
    <span class="input-group-addon kv-date-remove">
        <i class="glyphicon glyphicon-remove"></i>
    </span>
HTML;
  
    
  echo $form->field($model, 'date_start')->widget(DatePicker::classname(), [
    'type' => DatePicker::TYPE_RANGE,
    'options' => ['placeholder' => $model->getAttributeLabel('date_start')],
    'attribute2' => 'date_end',
    'options2' => ['placeholder' =>  $model->getAttributeLabel('date_end')],
     'separator' => '<i class="glyphicon glyphicon-resize-horizontal"></i>',
    'layout' => $layout3,
    'pluginOptions' => [
        'autoclose'=>true,
        //'datesDisabled' => LeaveDayOff::getList(),
        'format' => 'yyyy-mm-dd',
        'todayHighlight' => true,
        'todayBtn' => true,
        //'startDate' => date('Y-m-d', strtotime("+3 day")),
        //'calendarWeeks' => true,
        //'daysOfWeekDisabled' => [0, 6],
        
    ],
    'pluginEvents'=>[
        
    ]
    ])->label(false);
      
      
      
  ?>
    </div>
  </div>
   

   

   

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/structure', 'Create') : Yii::t('andahrm/structure', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
