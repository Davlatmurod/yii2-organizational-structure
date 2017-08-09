<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionOld */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-old-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="raw">
    
    <?= $form->field($model, 'code',['options' => ['class' => 'form-group col-xs-3 col-sm-3','enableAjaxValidation' => true]])->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title',['options' => ['class' => 'form-group col-xs-6 col-sm-6']])->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'status',['options' => ['class' => 'form-group col-xs-3 col-sm-3']])->textInput() ?>
    </div>

    <div class="raw">
        <?= $form->field($model, 'note',['options' => ['class' => 'form-group col-sm-12']])->textArea() ?>
     </div>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm/position-salary', 'Save'), ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
