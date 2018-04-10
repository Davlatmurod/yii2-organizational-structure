<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Position */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Position',
]) . $model->code;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>
<div class="position-update">

    <?= $this->render('_form', [
        'model' => $model,
        'formAction' => null
    ]) ?>

</div>
