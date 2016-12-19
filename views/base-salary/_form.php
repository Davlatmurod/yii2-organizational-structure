<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use andahrm\structure\models\PersonType;
use andahrm\structure\models\PositionType;
use andahrm\structure\models\PositionLevel;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\BaseSalary */
/* @var $form yii\widgets\ActiveForm */
$step = [];
$oldStep = array_combine((range(1,36,0.5)),(range(1,36,0.5)));
foreach($oldStep as $k=>$v){
  $step[Yii::$app->formatter->asDecimal($k,1)] = $v;
}
?>

<div class="base-salary-form">

    <?php $form = ActiveForm::begin(); ?>

     <div class="row">
      <div class="col-sm-3">
        <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(),['prompt'=>Yii::t('app','Select')]) ?>
      </div>
      <div class="col-sm-3">
          <?= $form->field($model, 'position_type_id')->dropDownList(PositionType::getList(),['prompt'=>Yii::t('app','Select')]) ?>
        </div>
        <div class="col-sm-3">
          <?= $form->field($model, 'position_level_id')->dropDownList(PositionLevel::getList(),['prompt'=>Yii::t('app','Select')]) ?>
        </div>
        <div class="col-sm-3">
           <?= $form->field($model, 'step')->dropDownList($step,['prompt'=>Yii::t('app','Select')]) ?>
        </div>
    </div>  

    <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/structure', 'Create') : Yii::t('andahrm/structure', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
