<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionLevel */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Position Level',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Position Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>
<div class="position-level-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
