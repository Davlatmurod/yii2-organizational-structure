<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="position-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'person_type_id') ?>

    <?= $form->field($model, 'section_id') ?>

    <?= $form->field($model, 'position_type_id') ?>

    <?= $form->field($model, 'number') ?>

    <?php // echo $form->field($model, 'name_manage') ?>

    <?php // echo $form->field($model, 'name_work') ?>

    <?php // echo $form->field($model, 'min_salary') ?>

    <?php // echo $form->field($model, 'max_salary') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
