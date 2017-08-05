<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

use andahrm\structure\models\PersonType;
 
 $this->beginContent('@andahrm/structure/views/layouts/main.php'); 
 $module = $this->context->module->id;
?>
<div class="row hidden-print">
    <div class="col-md-12"> 
      
    <?php
    $menuItems = [];
      
    $menuItems[] =  [
                        'label' => Yii::t('andahrm/structure', 'Positions'),
                        'url' => ["/{$module}/position"],
                        'icon' => 'fa fa-home'
                    ];
                    
    $menuItems[] =  [
                        'label' => Yii::t('andahrm/position-salary', 'Position Olds'),
                        'url' => ["/{$module}/position-old"],
                        'icon' => 'fa fa-home'
                    ];
     
     
                       
                    
                    //$nav = new Navigate();
                    echo Menu::widget([
                        'options' => ['class' => 'nav nav-tabs'],
                        //'options' => ['class' => 'nav nav-pills nav-stacked'],
                        'encodeLabels' => false,
                        //'activateParents' => true,
                        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                        'items' => $menuItems,
                    ]);
                    ?>
      
      
     
      
    </div>
</div>
<div class="row">
    <div class="col-md-12">
      
        <div class="x_panel tile" style="border-top: none;">
            <!--<div class="x_title">-->
            <!--    <h2><?= $this->title; ?></h2>-->
            <!--    <div class="clearfix"></div>-->
            <!--</div>-->
            <div class="x_content">
                <?php echo $content; ?>
                <div class="clearfix"></div>
            </div>
        </div>
      
    </div>
</div>

<?php $this->endContent(); ?>
