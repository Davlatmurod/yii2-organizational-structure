<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Structure */

$this->title = Yii::t('andahrm', 'Update {modelClass}: ', [
    'modelClass' => 'Structure',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Structures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm', 'Update');
?>


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>


