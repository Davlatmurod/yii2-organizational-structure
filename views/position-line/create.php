<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionLine */

$this->title = Yii::t('andahrm/structure', 'Create Position Line');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Position Lines'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-line-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
