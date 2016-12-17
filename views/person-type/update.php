<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PersonType */

$this->title = Yii::t('andahrm/structure', 'Update {modelClass}: ', [
    'modelClass' => 'Person Type',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Person Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/structure', 'Update');
?>
<div class="person-type-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
