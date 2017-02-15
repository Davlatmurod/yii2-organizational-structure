<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\helpers\Url;

use yii\web\JsExpression;
use wbraganca\fancytree\FancytreeWidget;

use andahrm\structure\models\Structure;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\structure\models\PositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('andahrm/structure', 'Organiaztional Structure');
$this->params['breadcrumbs'][] = $this->title;


firdows\orgchart\OrgChartAsset::register($this);
andahrm\structure\assets\MyChartAsset::register($this);


?>
<div id="content" style="margin-bottom:30px;">
  <div class="row">
  <div class="col-xs-12 col-sm-12 col-ml-12 col-lg-12">
    <div id="mainOrg">
    </div>
  </div>
  </div>
</div>


<?php

$this->registerJs("
var urlOrg = '".Url::to(['/structure/default/org'])."';
");
$this->registerJs("
  $('#mainOrg').orgchart({
        'data' : urlOrg,
        'nodeContent': 'title',
        'exportButton': true,
        'exportFilename': 'MyOrgChart',
        'depth': 4,
        'verticalDepth': 4,
        'pan': true,
        //'zoom': true,
        //'draggable': true
      });
");
?>


<?php if(Yii::$app->user->can('manage-structure')):?>
<div class="x_panel hidden-print">
  <div class="x_title">
    <h2>จัดการองค์กร<small> </small></h2>
    <div class="clearfix"></div>
  </div>

  <div class="x_content">
    <div class="row">
      <div class="col-sm-4">
        <div class="form-group">
          <?= Html::button('<i class="fa fa-tree"></i> '.Yii::t('andahrm/structure','Create Root'), ['id' =>'create-root', 'class' => 'btn btn-github btn-flat']); ?>
            <div class="pull-right">
              <?= Html::button('<i class="fa fa-plus"></i> '.Yii::t('andahrm/structure','Create Child'), ['id' =>'create-sub', 'class' => 'btn btn-success btn-flat']); ?>
            </div>
        </div>
        <?php
            echo FancytreeWidget::widget([
                'id' => 'category',
                'options' =>[
                    'source' => $treeArray,
                    'activate' => new JsExpression('function(event, data) {
    var node = data.node;
    $.get( "'.Url::to(['update']).'", { id: node.key } )
        .done(function( data ) {
            $("#form-tree").html(data);
    });
}'),
                    'extensions' => ['dnd',],
                    'dnd' => [
                        'preventVoidMoves' => true,
                        'preventRecursiveMoves' => true,
                        'autoExpandMS' => 400,
                        'dragStart' => new JsExpression('function(node, data) { return true; }'),
                        'dragEnter' => new JsExpression('function(node, data) { return true; }'),
                        'dragDrop' => new JsExpression('function(node, data) {
    $.get( "'.Url::to(['move-node']).'", { id: data.otherNode.key, mode: data.hitMode, targetId: data.node.key } )
        .done(function( dataAjax ) {
            if(dataAjax.process){
                data.otherNode.moveTo(node, data.hitMode);
            }
        },
    "json");
    }'
                        ),
                    ],
                ]
            ]);
            ?>
      </div>
      <div class="col-sm-8">
        <div id="form-tree">Loading...</div>
      </div>
    </div>
    <div class="clearfix"></div>
  </div>
</div>

<?php
$js[] = "$(document).on('click', '#create-root', function(){
    $.get('".Url::to(['create'])."').done(function(data){
        $('#form-tree').html(data);
        $('#category-name').focus();
    });
});";

$js[] = "$(document).on('click', '#create-sub', function(){
    var node = $('#fancyree_category').fancytree('getActiveNode');
      if( node ){
//        alert('Currently active: ' + node.key);
        $.get('".Url::to(['create'])."', { parent_id: node.key }).done(function(data){
            $('#form-tree').html(data);
            $('#category-name').focus();
        });
      }else{
        alert('No active node.');
      }
});";


$this->registerJs(implode("\n", $js));

if(Yii::$app->request->get('id')) {
    $this->registerJs("$(\"#fancyree_category\").fancytree(\"getTree\").activateKey(\"".Yii::$app->request->get('id')."\");");
}else{
    if(isset($treeArray[0])){
       $this->registerJs("$(\"#fancyree_category\").fancytree(\"getTree\").activateKey(\"".$treeArray[0]['key']."\");");
    }
}

endif;




