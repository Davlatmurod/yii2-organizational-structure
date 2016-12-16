<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionType */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Position Type',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Position Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="position-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
