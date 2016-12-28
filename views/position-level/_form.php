<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\structure\models\PositionType;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionLevel */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-level-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-3">
          <?= $form->field($model, 'position_type_id')->dropDownList(PositionType::getListGroup(),['prompt'=>Yii::t('app','Select')]) ?>
        </div>
      </div>
  
    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textArea() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/structure', 'Create') : Yii::t('andahrm/structure', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
