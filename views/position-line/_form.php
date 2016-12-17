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

    <?= $form->field($model, 'code')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(),['prompt'=>Yii::t('app','Select')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/structure', 'Create') : Yii::t('andahrm/structure', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
