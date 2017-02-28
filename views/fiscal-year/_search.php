<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\FiscalYearSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fiscal-year-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'year') ?>

    <?= $form->field($model, 'date_start') ?>

    <?= $form->field($model, 'date_end') ?>

    <?= $form->field($model, 'note') ?>

    <?= $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('andahrm', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('andahrm', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
