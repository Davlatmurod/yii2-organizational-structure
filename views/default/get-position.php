<?php

use yii\helpers\Html;
use yii\widgets\Pjax;
use yii\grid\GridView;

use andahrm\structure\models\PersonType;
use andahrm\structure\models\Section;
use andahrm\structure\models\PositionLine;
use andahrm\structure\models\PositionType;
use andahrm\structure\models\PositionLevel;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\structure\models\PositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/structure', 'Positions');
$this->params['breadcrumbs'][] = $this->title;

?>

<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            // [
            //     'class' => 'yii\grid\CheckboxColumn',
            //     'checkboxOptions' => function ($model, $key, $index, $column) {
            //       return ['checked'=>$model->getStructurePosition(Yii::$app->request->get('id'))];
            //     }
            // ],
    'codeTitle',
    //'title',
     [
                'attribute' => 'personPositionSalary.user.fullname',
                'value' => function($model){
                    $model = $model->personPositionSalary;
                    $user = $model?$model->user:null;
                    return $user?$user->fullname:null;
                }
            ],
    //  [
    //     'attribute' => 'position_line_id',
    //     'value' => 'positionLine.title'
    // ],
    [
        'content' => function ($model) use ($structure_id){
        $select = $model->getStructurePosition($structure_id);
         return $select?Html::a('<span class="glyphicon glyphicon-trash"></span>',  [
                        '/structure/default/update-position',
                        'id'=>$model->id,'position_id'=>$structure_id,'mode'=>'del',
                        ],['class'=>'btn btn-danger','data-pjax'=>'0'])
                        :Html::a('<i class="fa fa-plus"></i> เลือก',  [
                        '/structure/default/update-position',
                        'position_id'=>$model->id,'id'=>$structure_id,'mode'=>'add'
                        ],['class'=>'btn btn-success btn-add-position','pjax'=>0]);
        }
        ],
    //  [
    //     'attribute' => 'position_type_id',
    //     'value' => 'positionType.title'
    // ],
    //  [
    //     'attribute' => 'position_level_id',
    //     'value' => 'positionLevel.title'
    // ],
    //  [
    //             //'class' => 'yii\grid\CheckboxColumn',
    //             'content' => function ($model) {
    //               return $model->getStructurePosition(Yii::$app->request->get('id'));
    //             }
    //         ],
    
        ],
    ]); ?>



<?php
    $js[] = "
$(document).on('click', '.btn-add-position', function(e){
    //e.preventDefault();
    var url = $(this).attr('href');
    $.get(url,function(data){
        $.pjax.reload({container: '#position-selected-pjax'});
    });
    
    return false;
});
";

$this->registerJs(implode("\n", $js));


