<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use andahrm\edoc\models\Edoc;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Position */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-view">
    <p>
        <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>
    
    

    <?= DetailView::widget([
        'model' => $model,
        'options'=>['class'=>'table table-bordered'],
        'template'=> "<tr><th class='text-right'><h3>{label}</h3></th><td><h3>{value}</h3></td></tr>",
        'attributes' => [
            'code',
            'title'
        ],
    ]) ?>
    
    <div class="row">
        <div class="col-sm-8">
            
            <?= DetailView::widget([
        'model' => $model,
        'template'=> "<tr><th class='text-right'>{label}</th><td>{value}</td></tr>",
        'attributes' => [
            [
              'attribute'=>'person_type_id',
              'value' => $model->personType?$model->personType->title:null,
            ],
            [
              'attribute'=>'section_id',
              'value' => $model->section?$model->section->title:null,
            ],
            [
              'attribute'=>'position_line_id',
              'value' => $model->positionLine?$model->positionLine->title:null,
            ],
            [
              'attribute'=>'position_type_id',
              'value' => $model->positionType?$model->positionType->title:null,
            ],
            [
              'attribute'=>'position_level_id',
              'value' => $model->positionLevel?$model->positionLevel->title:null,
            ],
            [
              'attribute'=>'status',
              'format'=>'html',
              'value' => $model->statusLabel,
            ],
            'open_date:date',
             [
              'attribute'=>'close_date',
              'format'=>'html',
              'value' => $model->closeDateBtn,
            ],
        ],
    ]) ?>
            
        </div>
        <div class="col-sm-4">
            
             <?= DetailView::widget([
        'model' => $model,
        'template'=> "<tr><th class='text-right'>{label}</th><td>{value}</td></tr>",
        'attributes' => [
            
            
            //'min_salary',
            //'max_salary',
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by',
            'note',
        ],
    ]) ?>
            
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-12">
            <?=Html::tag('h2',Yii::t('andahrm/structure', 'Position History')) ?>
            <?=GridView::widget([
                'dataProvider' => $dataProvider,
                'columns'=>[
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'attribute' => 'adjust_date',
                        'format' => 'date'
                    ],
                    [
                        'attribute' => 'user_id',
                        'value'=>function($model){
                            return $model->user->fullname;
                        },
                        //'group'=>true
                    ],
                    'title',
                    'level',
                    [
                        'attribute'=>'edoc_id',
                        'filter' => Edoc::getList(),
                        'format' => 'html',
                        'content' => function($model){
                          return $model->edoc->codeDateTitleFileLink;
                        },
                    ]
                    ]
                ])?>
        </div>
    </div>
    
    
</div>
