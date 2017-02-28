<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\FiscalYear */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Fiscal Year',
]) . $model->yearThphase;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Fiscal Years'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->year, 'url' => ['view', 'id' => $model->year]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>
<div class="fiscal-year-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
