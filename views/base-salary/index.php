<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use andahrm\structure\models\PersonType;
use andahrm\structure\models\BaseSalary;
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
                            'salary',


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


        <?php  foreach(PersonType::getList() as $key => $type):?>
        <div role="tabpanel" class="tab-pane fade" id="tab_person<?=$key?>" aria-labelledby="person-tab<?=$key?>">
          <p>อัตราเงินเดือน<?=$type?></p>
          
          <?php //echo "<pre>"; print_r(BaseSalary::getBaseSalaryByPersonType($key));exit(); ?>
          <?php list($positionCode,$data) = BaseSalary::getBaseSalaryByPersonType($key); 
          if(isset($positionCode)  && isset($data)):
          ?>
          <?php //echo "<pre>"; print_r($data);exit(); ?>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>ขั้น</th>
                <?php foreach($positionCode as $key=>$title):?>
                <th><?=$title?></th>
                <?php endforeach;?>
              </tr>
            </thead>
            
          <tbody>
            
           <?php foreach($data as $step=>$val):?>
            <tr>
                 <td><?=$step?></td>                 
                   <?php foreach($positionCode as $key=>$title):?>
                    <td>
                        <?php if(isset($val[$key])):?>
                        <?=Yii::$app->formatter->asDecimal($val[$key]->salary,2);?>
                        <?php else:?> - <?php endif;?>
                    </td>
                  <?php endforeach;?>
           
              </tr>
            <?php endforeach;?>
            
           
          </tbody>
          </table>
          <?php endif;?>
        </div>
        <?php endforeach;?>

        
      </div>
    </div>                 
                          
</div>








