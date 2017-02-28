<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kuakling\datepicker\DatePicker;

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
    <?php if($model->isNewRecord):?>
    <div class="col-sm-4">
      <?= $form->field($model, 'year')->dropDownList(FiscalYear::getYearAll(),[
      'options'=>FiscalYear::getListSelected(),
      'prompt' => Yii::t('app','Select')
    ]) ?>
    </div>
    <div class="col-sm-2">
      <?= $form->field($model, 'phase')->dropDownList([1=>1,2=>2],[
      //'options'=>FiscalYear::getListSelected(),
      'prompt' => Yii::t('app','Select')
    ]) ?>
    </div>
    
    
    <?php else:?>
      <?=Html::tag('h2',$model->yearThphase)?>
      <?php endif;?>
    
  </div>
  
  
  <?php /*<div class="row">
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
  </div>*/ ?>
   <div class="row">
        <?= $form->field($model, 'date_start', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->widget(DatePicker::className());
        ?>
        <?= $form->field($model, 'date_end', [
            'options' => [
                'class' => 'form-group col-sm-6' 
            ]  
        ])->widget(DatePicker::className());
        ?>
<?php
$inputStartId = Html::getInputId($model, 'date_start');
$inputEndId = Html::getInputId($model, 'date_end');
$js[] = <<< JS
$("#{$inputStartId}").datepicker().on('changeDate', function(e) { $("#{$inputEndId}").datepicker('setStartDate', $(this).val()); });
$("#{$inputEndId}").datepicker().on('changeDate', function(e) { $("#{$inputStartId}").datepicker('setEndDate', $(this).val()); });
JS;
?>
    </div>

   

   

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = array_filter($js);
$this->registerJs(implode("\n", $js));
?>
