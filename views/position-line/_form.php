<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\structure\models\PersonType;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionLine */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-line-form">

    <?php $form = ActiveForm::begin(); ?>

      <div class="row">
        <div class="col-sm-3">
          <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(),['prompt'=>Yii::t('app','Select')]) ?>
        </div>
      </div>
  
   <div class="row">
      <div class="col-sm-3">
        <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>
      </div>
      <div class="col-sm-9">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
      </div>
  </div>
          
          
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/structure', 'Create') : Yii::t('andahrm/structure', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
