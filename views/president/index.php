<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use andahrm\structure\models\President;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\structure\models\PresidentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/structure', 'Presidents');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="president-index">

    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]);  ?>

    <p>
        <?= Html::a(Yii::t('andahrm/structure', 'Create President'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?=
    GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            //'user_id',
            [
                'attribute' => 'user_id',
                'value' => 'person.fullname'
            ],
            'start_date:date',
            'end_date:date',
            //'status',
            [
                'attribute' => 'status',
                'filter' => President::getItemStatus(),
                'value' => 'statusLabel'
            ],
            'note:ntext',
            //'created_at',
            //'created_by',
            //'updated_at',
            //'updated_by',
            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]);
    ?>
    <?php Pjax::end(); ?>
</div>
