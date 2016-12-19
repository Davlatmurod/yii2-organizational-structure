<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

 $this->beginContent('@app/views/layouts/main.php'); 
 $module = $this->context->module->id;
?>
<div class="row hidden-print">
    <div class="col-md-12"> 
      
      <?php
                    $menuItems = [
                        [
                            'label' => '<i class="fa fa-sitemap"></i> ' . Yii::t('andahrm/structure', 'Organiaztional Structure'),
                            'url' => ["/{$module}/default"],
                        ],
                        [
                            'label' => Html::icon('knight') . ' ' . Yii::t('andahrm/structure', 'Positions'),
                            'url' => ["/{$module}/position"],
                        ],
                        [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/structure', 'Person Types'),
                            'url' => ["/{$module}/person-type"],
                        ],
                        [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/structure', 'Sections'),
                            'url' => ["/{$module}/section"],
                        ],                      
                        [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/structure', 'Position Lines'),
                            'url' => ["/{$module}/position-line"],
                        ],
                        [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/structure', 'Position Types'),
                            'url' => ["/{$module}/position-type"],
                        ], 
                        [
                            'label' => Html::icon('inbox') . ' ' . Yii::t('andahrm/structure', 'Position Levels'),
                            'url' => ["/{$module}/position-level"],
                        ], 
                        [
                            'label' => Html::icon('dolla') . ' ' . Yii::t('andahrm/structure', 'Base Salaries'),
                            'url' => ["/{$module}/base-salary"],
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
                    ]);
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
