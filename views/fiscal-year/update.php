<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\FiscalYear */

$this->title = Yii::t('andahrm/structure', 'Update {modelClass}: ', [
    'modelClass' => 'Fiscal Year',
]) . $model->year;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Fiscal Years'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->year, 'url' => ['view', 'id' => $model->year]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/structure', 'Update');
?>
<div class="fiscal-year-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
