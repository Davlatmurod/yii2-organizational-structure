<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Structure */

$this->title = Yii::t('andahrm/structure', 'Create Structure');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Structures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="structure-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
