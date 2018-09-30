<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\President */

$this->title = $model->person->fullname;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Presidents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="president-view">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <p>
        <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'user_id' => $model->user_id, 'start_date' => $model->start_date], ['class' => 'btn btn-primary']) ?>
        <?=
        Html::a(Yii::t('andahrm', 'Delete'), ['delete', 'user_id' => $model->user_id, 'start_date' => $model->start_date], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm/structure', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ])
        ?>
    </p>

    <?=
    DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'user_id',
            [
                'attribute' => 'user_id',
                'value' => $model->person->fullname
            ],
            'start_date:date',
            'end_date:date',
            [
                'attribute' => 'status',
                'value' => $model->statusLabel
            ],
            //'status',
            'note:ntext',
//            'created_at',
//            'created_by',
//            'updated_at',
//            'updated_by',
        ],
    ])
    ?>

</div>
