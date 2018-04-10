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








