<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PersonType */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Person Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="person-type-view">

    <h1><?= Html::encode($this->title) ?></h1>

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
        'attributes' => [
            'id',
            'code',
            'title',
            'step_max',
            'note',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
