<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;

 $this->beginContent('@app/views/layouts/main.php'); 
 $module = $this->context->module->id;
?>
<div class="row">
    <div class="col-md-12"> 
      
      <?php
                    $menuItems = [
                            [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('app', 'ตำแหน่ง'),
                            'url' => ["/{$module}/default"], #2
                        ],
                            [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('app', 'โครงสร้างองค์กร'),
                            'url' => ["/{$module}/section"], #0
                        ],
                    ];
                    
                    //$nav = new Navigate();
                    echo Menu::widget([
                        'options' => ['class' => 'nav nav-tabs'],
                        'encodeLabels' => false,
                        //'activateParents' => true,
                        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                        'items' => $menuItems,
                    ])
                    ?>
      
      
     
      
    </div>
    </div>

<div class="row">
    <div class="col-md-12">
      
        <div class="x_panel tile">
            <div class="x_title">
                <h2><?= $this->title; ?></h2>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <?php echo $content; ?>
                <div class="clearfix"></div>
            </div>
        </div>
      
    </div>
</div>

<?php $this->endContent(); ?>
