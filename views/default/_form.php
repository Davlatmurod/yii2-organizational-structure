<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

use andahrm\structure\models\PersonType;
use andahrm\structure\models\Section;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\PositionType;
use andahrm\structure\models\PositionLevel;
use andahrm\structure\models\StructurePosition;

use yii\widgets\Pjax;
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
        <?= $form->field($model, 'position_line_id')->dropDownList(PositionLine::getListGroup(),['prompt'=>Yii::t('app','Select')]) ?>
      </div>
    </div>  
  
   <div class="row">
    <div class="col-sm-12">
      <?=Html::activeLabel((new StructurePosition),'position_id')?>
      <div class="position_area">
          <?php
  if($model->isNewRecord){
        echo "<p class='text-warning'>".Yii::t('andahrm/structure', 'Please choose Section and Postion Line')."</p>";
  }else{
       
        echo Yii::$app->runAction('/structure/default/get-position',['section_id'=>$model->section_id,'position_line_id'=>$model->position_line_id,'structure_id'=>$model->id]);
        
  }?>
      </div>
    </div>
  </div>
  

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
  
    <?= $form->field($model, 'status')->dropDownList([]);?>

    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>    
    
    

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php



    $js = [];
    $js[] ="var url = '".Url::to(['/structure/default/get-position'],true)."'";
    $js[] ="var structure_id = '".(!$model->isNewRecord ?$model->id:'')."'";
    $js[] = "$(document).on('change', '#structure-section_id,#structure-position_line_id', function(){
    
        var section_id = $('#structure-section_id option:selected').val();
        var position_line_id = $('#structure-position_line_id option:selected').val();
        if(section_id && position_line_id){
          loadPosition(section_id,position_line_id,structure_id);
        }else{
          $('.position_area').html('<p class=\"text-warning\">".Yii::t('andahrm/structure', 'Please choose Section and Postion Line')."</p>');
        }
        
    });";    

  $js[] = "function loadPosition(section_id,position_line_id,structure_id){
  
  //alert(section_id+' '+position_line_id+' '+url);
  
      $.get(
          url,
          {
            section_id:section_id,
            position_line_id:position_line_id,
            structure_id:structure_id
          },
          function(data){
            $('.position_area').html(data);
          }
      )
  }";



$this->registerJs(implode("\n",$js));

