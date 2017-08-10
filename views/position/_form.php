<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use andahrm\structure\models\PersonType;
use andahrm\structure\models\Section;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\PositionType;
use andahrm\structure\models\PositionLevel;
use andahrm\structure\models\Position;

use kartik\widgets\Select;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Position */
/* @var $form yii\widgets\ActiveForm */
?>

  <div class="position-form">

    <?php $form = ActiveForm::begin(); ?>
   

    <div class="row">
      <div class="col-sm-2">
         <?= $form->field($model, 'person_type_id')->dropDownList(PersonType::getList(),[
          'prompt'=>Yii::t('app','Select'),
          'id'=>'ddl-person_type',
        ]) ?>
      </div>
      <div class="col-sm-4">
        <?= $form->field($model, 'section_id')->dropDownList(Section::getList(),['prompt'=>Yii::t('app','Select')]) ?>
      </div>
      <div class="col-sm-3">        
        <?= $form->field($model, 'position_line_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-position_line'],
            'data'=> PositionLine::getPositionLines($model->person_type_id),
            'type'=>DepDrop::TYPE_SELECT2,
            'pluginOptions'=>[
                'depends'=>['ddl-person_type'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['/structure/position/get-position-line'])
            ],
            'pluginEvents' => [
              //'change' => "function(event, id, value, count) { alert(value); }",
              ]
        ]); ?>
      </div>
      <div class="col-sm-3">
        <?= $form->field($model, 'number' ,['enableAjaxValidation' => true])->textInput() ?>
      </div>
    </div>


   <?= $form->field($model, 'code')->textInput(['value'=>$model->generatCode]) ?>
   
<?php /*if(!$model->isNewRecord):?>
<div class="row">
      <div class="col-sm-12">
        <?=Html::activeLabel($model,'code');?>
        <?=$model->code?>
      </div>
</div>
<?php endif; */?>


    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

      <div class="row">
        <div class="col-sm-6">
          <?= $form->field($model, 'position_type_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-position_type'],
            'data'=> PositionType::getPositionTypes($model->person_type_id),
            'type'=>DepDrop::TYPE_SELECT2,
            'pluginOptions'=>[
                'depends'=>['ddl-person_type'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['/structure/position/get-position-type'])
            ],
            'pluginEvents' => [
              //'change' => "function(event, id, value, count) { alert(value); }",
              ]
        ]); 
          
          //->dropDownList(PositionType::getList(),['prompt'=>Yii::t('app','Select')])
          ?>
        </div>
        <div class="col-sm-6">
          <?= $form->field($model, 'position_level_id')->widget(DepDrop::classname(), [
            'options'=>['id'=>'ddl-position_level'],
            'data'=> PositionLevel::getPositionLevels($model->person_type_id,$model->position_type_id),
            'type'=>DepDrop::TYPE_SELECT2,
            'pluginOptions'=>[
                'depends'=>['ddl-position_type'],
                'placeholder'=>Yii::t('app','Select'),
                'url'=>Url::to(['/structure/position/get-position-level'])
            ],
            'pluginEvents' => [
              //'change' => "function(event, id, value, count) { alert(value); }",
              ]
        ]);  ?>
        </div>
      </div>


      <!--<div class="row">-->
      <!--  <div class="col-sm-6">-->
      <!--    <?= $form->field($model, 'min_salary')->textInput() ?>-->
      <!--  </div>-->
      <!--  <div class="col-sm-6">-->
      <!--    <?= $form->field($model, 'max_salary')->textInput() ?>-->
      <!--  </div>-->
      <!--</div>-->
    
    
      <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>



        <div class="form-group">
          <?= Html::submitButton($model->isNewRecord ? Yii::t('andahrm', 'Create') : Yii::t('andahrm', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

  </div>
  
<?php
 $position_line_id =  Html::getInputId($model, 'position_line_id');
 $title =  Html::getInputId($model, 'title');
  
$js[] = <<< JS
  $("#ddl-position_line").on('change',function(){
     if($(this).val()){
       var label = $(".select2-selection__rendered").text();
       label = label.slice(0,label.indexOf("("));
       $("#{$title}").val(label);
     }
  });
  
JS;
  
  
  $this->registerJs(implode("\n", $js));
  ?>