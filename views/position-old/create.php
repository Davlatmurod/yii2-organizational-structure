<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionOld */

$this->title = Yii::t('andahrm/position-salary', 'Create Position Old');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/position-salary', 'Position Olds'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-old-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'formAction' => null
    ]) ?>

</div>
