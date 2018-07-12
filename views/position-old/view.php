<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionOld */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Position Olds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-old-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm/position-salary', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('andahrm/position-salary', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm/position-salary', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'options' => ['class' => 'table table-bordered'],
        'template' => "<tr><th class='text-right'><h3>{label}</h3></th><td><h3>{value}</h3></td></tr>",
        'attributes' => [
            'code',
            'title'
        ],
    ])
    ?>

    <div class="row">
        <div class="col-sm-8">

            <?=
            DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'status',
                    'note',
                ],
            ])
            ?>

        </div><div class="col-sm-4">

            <?=
            DetailView::widget([
                'model' => $model,
                'template' => "<tr><th class='text-right'>{label}</th><td>{value}</td></tr>",
                'attributes' => [
                    'created_at:datetime',
                    'created_by',
                    'updated_at:datetime',
                    'updated_by',
                ],
            ])
            ?>

        </div>
    </div>

    <div class="row">
        <div class="col-sm-12">
            <?= Html::tag('h2', Yii::t('andahrm/structure', 'Position History')) ?>
            <?=
            GridView::widget([
                'dataProvider' => $dataProvider,
                'columns' => [
                    ['class' => '\kartik\grid\SerialColumn'],
                    [
                        'attribute' => 'adjust_date',
                        'format' => 'date'
                    ],
                    [
                        'attribute' => 'user_id',
                        'value' => function($model) {
                            return $model->user->fullname;
                        },
                    //'group'=>true
                    ],
                    'title',
                    'level',
                    [
                        'attribute' => 'edoc_id',
                        // 'filter' => Edoc::getList(),
                        'format' => 'html',
                        'content' => function($model) {
                            return $model->edoc->codeDateTitleFileLink;
                        },
                    ]
                ]
            ])
            ?>
        </div>
    </div>



</div>
