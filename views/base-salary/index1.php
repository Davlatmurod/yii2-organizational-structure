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
<div class="base-salary-index">

    
  <div class="" role="tabpanel" data-example-id="togglable-tabs">
      <ul id="myTab" class="nav nav-tabs bar_tabs hidden-print" role="tablist">
        
        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">ทั้งหมด</a>
        </li>

        <?php  foreach(PersonType::getList() as $key => $type):?>
        <li role="presentation" class="">
          <a href="#tab_person<?=$key?>" role="tab" id="person-tab<?=$key?>" data-toggle="tab" aria-expanded="false"><?=$type?></a>
        </li>
        <?php endforeach;?>


      </ul>
    
    
      <div id="myTabContent" class="tab-content">
        <div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
          <p>
           <?= Html::a(Yii::t('andahrm/structure', 'Create Base Salary'), ['create'], ['class' => 'btn btn-success']) ?>
         </p>
                <?php Pjax::begin(); ?>    
                  <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            //'id',
                            [
                                'attribute' => 'person_type_id',
                                'filter' => PersonType::getList(),
                                'value' => 'personType.title'
                            ],
                            'step',
                            'title',           
                           [
                                'attribute' => 'salary',
                               'format' => 'decimal',
                                'contentOptions'=>['class'=>'text-right']
                            ],

                            // 'note',
                            'created_at',
                            'created_by',
                            // 'updated_at',
                            // 'updated_by',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                <?php Pjax::end(); ?>
                          
      </div>


        
<!--        ********************** ************************** -->
        
        
        
        
        
        <?php  foreach(PersonType::getList() as $key => $type):?>
       
        <div role="tabpanel" class="tab-pane fade" id="tab_person<?=$key?>" aria-labelledby="person-tab<?=$key?>">
         
       
        <?php endforeach;?>

        
      </div>
    </div>                 
                          
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








