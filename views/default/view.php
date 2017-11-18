<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model andahrm\structure\models\Structure */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('andahrm/structure', 'Structures'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="structure-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('andahrm', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary btn-update']) ?>
        <?= Html::a(Yii::t('andahrm', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('andahrm', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            //'id',
            //'root',
            //'lft',
            //'rgt',
            //'level',
            'title',
            'section_id',
            'position_line_id',
            'status',
            'note:ntext',
            'created_at',
            'created_by',
            'updated_at',
            'updated_by',
        ],
    ]) ?>

</div>
<?php
$urlUpdate = Url::to(['update','id'=>$model->id]);
if(Yii::$app->request->isAjax){

$js[] = <<< JS
//alert(555);
$('.btn-update').click(function(){
    //alert(555);
    $.get($(this).attr('href')).done(function( data ) {
       $("#form-tree").html(data);
    });
    
    return false;

});

JS;


$this->registerJs(implode($js));
}