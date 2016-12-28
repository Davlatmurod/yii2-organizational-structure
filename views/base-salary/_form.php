<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use andahrm\structure\models\PersonType;
use andahrm\structure\models\PositionType;
use andahrm\structure\models\PositionLevel;
use andahrm\structure\models\BaseSalary;

use kartik\widgets\DepDrop;

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
        <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(),[
          'prompt'=>Yii::t('app','Select'),
          'id'=>'ddl-person_type',
        ]) ?>
      </div>
      <div class="col-sm-3">
          <?= $form->field($model, 'position_type_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-position_type'],
            'data'=> BaseSalary::getPositionTypes($model->person_type_id),
            'pluginOptions'=>[
                'depends'=>['ddl-person_type'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['/structure/base-salary/get-position-type'])
            ]
        ]); ?>
        </div>
        <div class="col-sm-3">
          <?= $form->field($model, 'position_level_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-position_level'],
            'data'=> BaseSalary::getPositionLevels($model->position_type_id),
            'pluginOptions'=>[
                'depends'=>['ddl-position_type','ddl-person_type'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['/structure/base-salary/get-position-level'])
            ]
        ]); ?>
        </div>
        <div class="col-sm-3">
           <?= $form->field($model, 'step')->dropDownList($step,['prompt'=>Yii::t('app','Select')]) ?>
        </div>
    </div>  

    <?= $form->field($model, 'salary')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>


    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
