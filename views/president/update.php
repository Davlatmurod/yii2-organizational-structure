<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\President */

$this->title = Yii::t('andahrm/structure', 'Update President: ' . $model->user_id, [
    'nameAttribute' => '' . $model->user_id,
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Presidents'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->user_id, 'url' => ['view', 'id' => $model->user_id]];
$this->params['breadcrumbs'][] = Yii::t('andahrm/structure', 'Update');
?>
<div class="president-update">

<!--    <h1><?= Html::encode($this->title) ?></h1>-->

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
