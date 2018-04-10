<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\structure\models\PositionType;
use andahrm\structure\models\PersonType;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionLevel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-level-form">
    
    <?=Html::errorSummary($model)?>

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        
        <div class="col-sm-3">
          <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(),['prompt'=>Yii::t('app','Select')]) ?>
        </div>
        
        <div class="col-sm-3">
          <?= $form->field($model, 'position_type_id')->dropDownList(PositionType::getListGroup(),['prompt'=>Yii::t('app','Select')]) ?>
        </div>
      </div>
  
  
   <div class="row">
        
        <div class="col-sm-8">
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
     </div>
        
        <div class="col-sm-3">
    <?= $form->field($model, 'level')->textInput(['maxlength' => true]) ?>
    </div>
      </div>

    <?= $form->field($model, 'note')->textArea() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
