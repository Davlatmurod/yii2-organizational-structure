<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\structure\models\PersonType;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionType */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-type-form">

    <?php $form = ActiveForm::begin(); ?>
  
     <div class="row">
      <div class="col-sm-3">
        <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(),['prompt'=>Yii::t('app','Select')]) ?>
      </div>
      <div class="col-sm-9">
        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
      </div>
    </div>
  
    <?= $form->field($model, 'note')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
