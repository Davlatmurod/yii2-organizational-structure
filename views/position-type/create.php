<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionType */

$this->title = Yii::t('andahrm/structure', 'Create Position Type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Position Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-type-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
