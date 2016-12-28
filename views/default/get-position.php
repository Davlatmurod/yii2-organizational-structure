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
            [
                'class' => 'yii\grid\CheckboxColumn',
                'checkboxOptions' => function ($model, $key, $index, $column) {
                  return ['checked'=>$model->getStructurePosition(Yii::$app->request->get('id'))];
                }
            ],
    'code',
    'title',
     [
        'attribute' => 'position_line_id',
        'value' => 'positionLine.title'
    ],
     [
        'attribute' => 'position_type_id',
        'value' => 'positionType.title'
    ],
     [
        'attribute' => 'position_level_id',
        'value' => 'positionLevel.title'
    ],
        ],
    ]); ?>


