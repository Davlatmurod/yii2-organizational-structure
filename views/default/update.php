<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Structure */

$this->title = Yii::t('andahrm/structure', 'Update {modelClass}: ', [
    'modelClass' => 'Structure',
]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Structures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/structure', 'Update');
?>
<div class="structure-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
