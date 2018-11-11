<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Structure */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Structures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


$modals['position'] =  Modal::begin([
    'id'=>'add_position',
    'header' => Yii::t('andahrm/structure', 'Add Position'),
    'size' => Modal::SIZE_LARGE
]);
echo Yii::$app->runAction('/structure/default/add-position',['id'=>$model->id, 'formAction' => Url::to(['/structure/default/add-position'])]);

Modal::end();
?>
<div class="structure-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-update']) ?>
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
        'attributes' => [
            'title',
            //'section_id',
            //'position_line_id',
            //'status',
            'note:ntext',
            'created_at:datetime',
            'created_by',
            'updated_at:datetime',
            'updated_by',
        ],
    ]) ?>
    
    
    <?=Html::button('เพิ่มตำแหน่ง',
    [
        'class'=>'btn btn-success',
        'data-toggle' => 'modal',
        'data-target' => "#{$modals['position']->id}",
    ]
    )?>
    
    
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'id' => 'position-selected',
        'pjax'=>true,
        'columns' => [
            // [
            //     'class' => 'yii\grid\CheckboxColumn',
            //     'checkboxOptions' => function ($model, $key, $index, $column) {
            //       return ['checked'=>$model->getStructurePosition(Yii::$app->request->get('id'))];
            //     }
            // ],
            [
             'attribute'=>'position.title',
             'value'=>'position.codeTitle',
            ],
             [
                'attribute' => 'position.user.fullname',
                'value' => function($model){
                    $model = $model->position;
                    $user = $model->user?$model->user:null;
                    return $user?$user->fullname:null;
                }
            ],
            //  [
            //     //'attribute' => 'position_type_id',
            //     'value' => 'position.positionType.title'
            // ],
            //  [
            //     //'attribute' => 'position_level_id',
            //     'value' => 'position.positionLevel.title'
            // ],
             [
                //'attribute' => 'position_level_id',
                'content' => function($model){
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>',  [
                        '/structure/default/update-position',
                        'id'=>$model->structure_id,
                        'position_id'=>$model->position_id,
                        'mode'=>'del',
                        ],['class'=>'btn btn-danger','data-pjax'=>'0']);
                }
            ],
                ],
    ]); ?>

</div>
<?php
$urlUpdate = Url::to(['update','id'=>$model->id]);
if(Yii::$app->request->isAjax){

$js[] = <<< JS
//alert(555);
$('.btn-update').click(function(){
    //alert(555);
    $.get($(this).attr('href')).done(function( data ) {
       $("#form-tree").html(data);
    });
    
    return false;

});

JS;


$this->registerJs(implode($js));

}

// $modalPosition = $modals['position']->id;
// $js[] = <<< JS


// $("#{$modalPosition}").click(function(){
//         $('.modal').modal('show')
//             .find('#modelContent')
//             .load($(this).attr('value'));
//     });
// JS;

// $this->registerJs(implode($js));
