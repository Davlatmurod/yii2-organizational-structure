<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

use andahrm\structure\models\PersonType;
use andahrm\structure\models\Section;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\PositionType;
use andahrm\structure\models\PositionLevel;
/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Structure */
/* @var $form yii\widgets\ActiveForm */
?>

 <h3><?= Html::encode($this->title) ?></h3>

<div class="structure-form">

    <?php $form = ActiveForm::begin(); ?>    

   <div class="row">
      <div class="col-sm-6">
        <?= $form->field($model, 'section_id')->dropDownList(Section::getList(),['prompt'=>Yii::t('app','Select')]) ?>
      </div>
      <div class="col-sm-6">
        <?= $form->field($model, 'position_line_id')->dropDownList(PositionLine::getList(),['prompt'=>Yii::t('app','Select')]) ?>
      </div>
    </div>  

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    
    
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm/structure', 'Create') : Yii::t('andahrm/structure', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
