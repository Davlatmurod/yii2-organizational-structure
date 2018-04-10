<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\structure\models\PersonTypeSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/structure', 'Person Types');
$this->params['breadcrumbs'][] = $this->title;
?>
<?php
$columns = [
    'id' => 'id',
    'code' => ['attribute'=>'code','group'=>true],
    'parent' => [
        'attribute'=>'parent',
    'value'=>'parent.title',
    'group'=>true,
    ],
    'title' => 'title',
    'step_max' => 'step_max',
    'created_at' => 'created_at:datetime',
    'created_by' => 'created_by',
    'updated_at' => 'updated_at',
    'updated_by' => 'updated_by',
];

$gridColumns = [
   ['class' => '\kartik\grid\SerialColumn'],
    $columns['parent'],
    $columns['code'],
    $columns['title'],
    $columns['step_max'],
    $columns['created_at'],
    $columns['created_by'],
    ['class' => '\kartik\grid\ActionColumn',]
];

$fullExportMenu = ExportMenu::widget([
    'dataProvider' => $dataProvider,
    'columns' => $columns,
    'filename' => $this->title,
    'showConfirmAlert' => false,
    'target' => ExportMenu::TARGET_BLANK,
    'fontAwesome' => true,
    'pjaxContainerId' => 'kv-pjax-container',
    'dropdownOptions' => [
        'label' => 'Full',
        'class' => 'btn btn-default',
        'itemsBefore' => [
            '<li class="dropdown-header">Export All Data</li>',
        ],
    ],
]);
?>
<div class="person-index">

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'id' => 'data-grid',
        'pjax'=>true,
//        'resizableColumns'=>true,
//        'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
//        'floatHeader'=>true,
//        'floatHeaderOptions'=>['scrollingTop'=>'50'],
        'export' => [
            'label' => Yii::t('yii', 'Page'),
            'fontAwesome' => true,
            'target' => GridView::TARGET_SELF,
            'showConfirmAlert' => false,
        ],
//         'exportConfig' => [
//             GridView::HTML=>['filename' => $exportFilename],
//             GridView::CSV=>['filename' => $exportFilename],
//             GridView::TEXT=>['filename' => $exportFilename],
//             GridView::EXCEL=>['filename' => $exportFilename],
//             GridView::PDF=>['filename' => $exportFilename],
//             GridView::JSON=>['filename' => $exportFilename],
//         ],
        'panel' => [
            //'heading'=>'<h3 class="panel-title"><i class="fa fa-th"></i> '.Html::encode($this->title).'</h3>',
//             'type'=>'primary',
            'before'=> '<div class="btn-group">'.
                Html::a('<i class="glyphicon glyphicon-plus"></i> '.Yii::t('andahrm', 'Create'), ['create'], [
                    'class' => 'btn btn-success btn-flat',
                    'data-pjax' => 0
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-repeat"></i> '.Yii::t('andahrm', 'Reload'), '#!', [
                    'class' => 'btn btn-info btn-flat btn-reload',
                    'title' => 'Reload',
                    'id' => 'btn-reload-grid'
                ]) . ' '.
                Html::a('<i class="glyphicon glyphicon-trash"></i> '.Yii::t('andahrm', 'Trash'), ['trash/index'], [
                    'class' => 'btn btn-warning btn-flat',
                    'data-pjax' => 0
                ]) . ' '.
                '</div>',
                'heading'=>false,
                //'footer'=>false,
        ],
        'toolbar' => [
            '{export}',
            '{toggleData}',
            $fullExportMenu,
        ],
        'columns' => $gridColumns,
    ]); ?>
</div>
<?php
$js[] = "
$(document).on('click', '#btn-reload-grid', function(e){
    e.preventDefault();
    $.pjax.reload({container: '#data-grid-pjax'});
});
";

$this->registerJs(implode("\n", $js));
