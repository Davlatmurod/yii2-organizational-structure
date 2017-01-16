<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\FiscalYear */

$this->title = $model->year;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Fiscal Years'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fiscal-year-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm/structure', 'Update'), ['update', 'id' => $model->year], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('andahrm/structure', 'Delete'), ['delete', 'id' => $model->year], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm/structure', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'year',
            'date_start',
            'date_end',
            'note:ntext',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
