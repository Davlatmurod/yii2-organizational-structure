<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Position */

$this->title = Yii::t('andahrm/structure', 'Create Position');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Positions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="position-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>