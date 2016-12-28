<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use yii\widgets\Pjax;
use andahrm\structure\models\PersonType;
use andahrm\structure\models\BaseSalary;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\structure\models\BaseSalarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/structure', 'Base Salaries');
$this->params['breadcrumbs'][] = $this->title;
?>
 <p>อัตราเงินเดือน</p>
          
          <?php //echo "<pre>"; print_r(BaseSalary::getBaseSalaryByPersonType($key));exit(); ?>
          <?php list($positionCode,$data) = BaseSalary::getBaseSalaryByPersonType($key); 
          if(isset($positionCode)  && isset($data)):
          ?>
          <?php //echo "<pre>"; print_r($data);exit(); ?>
          
           <?php 
           Pjax::begin([
        //'id' => 'translates'
    ]);
          
//           $form = ActiveForm::begin([
//                 'method' => 'get',
//                 'id' => 'search-form',
//                 'enableAjaxValidation' => false,
//                 'enableClientValidation' => false,
//     ]); 
          ?>
          <table class="table table-bordered" id="tb_salary">
            <thead>
              <tr>
                <th class="text-center">ขั้น</th>
                <?php foreach($positionCode as $key=>$title):?>
                <th class="text-center"><?=$title?></th>
                <?php endforeach;?>
              </tr>
            </thead>
            
          <tbody>
            
           <?php foreach($data as $step=>$val):?>
            <tr>
                 <td class="text-center"><?=$step?></td>                 
                   <?php foreach($positionCode as $key=>$title):
                   $model = (isset($val[$key]))?$val[$key]:new BaseSalary();
              ?>
                    <td class="text-center">
                        <?php /*if(isset($val[$key])):
                      $model = $val[$key];
                      ?>
                        <?=Html::a(
                        Yii::$app->formatter->asDecimal($model->salary,0),
                        ['view','id'=>$model->id]
                        );?>
                        <?php else:?> - <?php endif;*/ ?>
                      <?php //$form->field($model, 'salary')->textInput(['maxlength' => true])->label(false) ?>
                      <?php if(Yii::$app->user->can('manager-salary')): ?>
                      <?= Html::textInput("salary",$model->salary,[
                          'class'=>'salary',
                          'data-id'=>$model->id?$model->id:'',
                          'data-key'=>$key,
                          'data-step'=>$step,
                          'style'=>'width:50px;'
                      ])?>
                      <?php else:?>
                      <?=$model->salary?>
                      <?php endif;?>
                    </td>
                  <?php endforeach;?>
           
              </tr>
            <?php endforeach;?>
            
           
          </tbody>
          </table>
           <?php //ActiveForm::end(); ?>
           <?php Pjax::end(); ?>
          <?php endif;?>
        </div>

<?php
$js=[];
$js[]= " var urlSalary = '".Url::to(['save'])."'";
$js[]= "
    
    var _originalSalary;
    $('#tb_salary').on('focus', '.salary', function () {
        _originalSalary = $(this).val();
        console.log(_originalSalary);
    });
    
    $('#tb_salary').on('blur', '.salary', function () {
        if ($(this).val() != _originalSalary) {
          //console.log($(this).data('key'));
             var data = {
                id: $(this).data('id'),
                step: $(this).data('step'),
                key: $(this).data('key'),
                val: $(this).val() 
            };                  
            updateSalary(data);
        }
    });
";
$js[]= "
    function updateSalary(data){
        //alert(data);
        console.log(data);
        
        $.post(
          urlSalary, 
          data, 
          $.proxy(function (data) {
                    
                }, this), 'json');
    }
";

$this->registerJs(implode("\n",$js));








