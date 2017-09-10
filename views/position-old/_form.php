<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionOld */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-old-form">

<?php
  $formOptions=[];
  //$formOptions['options'] = ['enctype' => 'multipart/form-data'];
  if($formAction !== null)  $formOptions['action'] = $formAction;
  ?>
    <?php $form = ActiveForm::begin($formOptions); ?>

    <div class="raw">
    
    <?= $form->field($model, 'code',['options' => ['class' => 'form-group col-xs-3 col-sm-3','enableAjaxValidation' => true]])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title',['options' => ['class' => 'form-group col-xs-6 col-sm-6']])->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'status',['options' => ['class' => 'form-group col-xs-3 col-sm-3']])->textInput() ?>
    </div>

    <div class="raw">
        <?= $form->field($model, 'note',['options' => ['class' => 'form-group col-sm-12']])->textArea() ?>
     </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm/position-salary', 'Save'), ['class' => 'btn btn-success','name'=>'save','value'=>1]) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
///Surakit
if($formAction !== null) {
  $eer = Yii::t('app','Select');
$js[] = <<< JS
$(document).on('submit', '#{$form->id}', function(e){
  e.preventDefault();
  var form = $(this);
  var formData = new FormData(form[0]);
  // alert(form.serialize());
  
  $.ajax({
    url: form.attr('action'),
    type : 'POST',
    data: formData,
    contentType:false,
    cache: false,
    processData:false,
    dataType: "json",
    success: function(data) {
      if(data.success){
        callbackPosition(data.result,"#{$form->id}");
      }else{
        alert('Fail');
        alert(data);
      }
    }
  });
});
JS;

$this->registerJs(implode("\n", $js));
}
?>