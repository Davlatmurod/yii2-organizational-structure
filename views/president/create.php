<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\President */

$this->title = Yii::t('andahrm/structure', 'Create President');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Presidents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="president-create">
<!--
    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
