<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\PositionLevel */

$this->title = Yii::t('andahrm/structure', 'Create Position Level');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Position Levels'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-level-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
