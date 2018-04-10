<?php

use yii\helpers\Html;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel andahrm\structure\models\FiscalYearSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/structure', 'Fiscal Years');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fiscal-year-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('andahrm/structure', 'Create Fiscal Year'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'kartik\grid\SerialColumn'],

            [
                'attribute' => 'year',
                'value' => 'yearTh',
                'group' => true,
            ],
            'phase',
            'date_start:date',
            'date_end:date',
            'note:ntext',
            'created_at',
            // 'created_by',
            // 'updated_at',
            // 'updated_by',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
