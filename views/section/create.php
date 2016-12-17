<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Section */

$this->title = Yii::t('andahrm/structure', 'Create Section');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Sections'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="section-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
