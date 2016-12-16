<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

 $this->beginContent('@app/views/layouts/main.php'); 
 $module = $this->context->module->id;
?>
<div class="row">
    <div class="col-md-12"> 
      
      <?php
                    $menuItems = [
                        [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('app', 'ตำแหน่ง'),
                            'url' => ["/{$module}/default"],
                        ],
                        [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('app', 'ประเภทบุคคล'),
                            'url' => ["/{$module}/person-type"],
                        ],
                        [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('app', 'โครงสร้างองค์กร'),
                            'url' => ["/{$module}/section"],
                        ],
                        [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('app', 'ร'),
                            'url' => ["/{$module}/person-type"],
                        ],
                    ];
                    $menuItems = Helper::filter($menuItems);
                    
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
