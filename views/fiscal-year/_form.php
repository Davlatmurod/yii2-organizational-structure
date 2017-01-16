<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use andahrm\structure\models\FiscalYear;
/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\FiscalYear */
/* @var $form yii\widgets\ActiveForm */
print_r(FiscalYear::getListSelected());
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
      <?=$model->yearTh?>
      <?php endif;?>
    </div>
  </div>
  
  
  <div class="row">
    <div class="col-sm-6">
 <?= $form->field($model, 'date_start')->textInput() ?>
    </div>
    <div class="col-sm-6">
  <?= $form->field($model, 'date_end')->textInput() ?>
    </div>
  </div>
   

   

   

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/structure', 'Create') : Yii::t('andahrm/structure', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
