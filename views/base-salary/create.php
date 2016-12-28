<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\BaseSalary */

$this->title = Yii::t('andahrm/structure', 'Create Base Salary');
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Base Salaries'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="base-salary-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
