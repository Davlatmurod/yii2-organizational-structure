<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

 $this->beginContent('@app/views/layouts/main.php'); 
 $module = $this->context->module->id;
 $controller = $this->context->id;
?>
<div class="row hidden-print">
    <div class="col-md-12"> 
      
      <?php
                    $menuItems = [
                        [
                            'label' => Yii::t('andahrm/structure', 'Organiaztional Structure'),
                            'url' => ["/{$module}/default"],
                            'icon' => 'fa fa-sitemap'
                        ],                      
                        [
                            'label' => Yii::t('andahrm/structure', 'Positions'),
                            'url' => ["/{$module}/position"],
                            'icon' => 'fa fa-id-badge',
                            'active'=>($controller=="position"||$controller=="position-old")?"active":""
                        ],
                        [
                            'label' => Yii::t('andahrm/structure', 'Fiscal Years'),
                            'url' => ["/{$module}/fiscal-year"],
                            'icon' => 'fa fa-calendar'
                        ], 
                        
                        [
                            'label' => Yii::t('andahrm/structure', 'Sections'),
                            'url' => ["/{$module}/section"],
                            'icon' => 'fa fa-group'
                        ],  
                        [
                            'label' => Yii::t('andahrm/structure', 'Person Types'),
                            'url' => ["/{$module}/person-type"],
                            'icon' => 'fa fa-vcard'
                        ],                 
                        [
                            'label' => Yii::t('andahrm/structure', 'Position Lines'),
                            'url' => ["/{$module}/position-line"],
                            'icon' => 'fa fa-pagelines'
                        ],
                        [
                            'label' => Yii::t('andahrm/structure', 'Position Types'),
                            'url' => ["/{$module}/position-type"],
                            'icon' => 'fa fa-user-circle'
                        ], 
                         [
                            'label' => Yii::t('andahrm/structure', 'Position Levels'),
                            'url' => ["/{$module}/position-level"],
                            'icon' => 'fa fa-level-up '
                        ], 
                        
                        [
                            'label' => Yii::t('andahrm/structure', 'Base Salaries'),
                            'url' => ["/{$module}/base-salary"],
                            'icon' => 'fa fa-money'
                        ],   
                        [
                            'label' => Yii::t('andahrm/structure', 'Presidents'),
                            'url' => ["/{$module}/president"],
                            'icon' => 'fa fa-user-circle'
                        ],   
                        
                       
                        
                    ];
                    $menuItems = Helper::filter($menuItems);
                    
                    //$nav = new Navigate();
                    echo Menu::widget([
                        'options' => ['class' => 'nav nav-tabs bar_tabs'],
                        'encodeLabels' => false,
                        //'activateParents' => true,
                        //'linkTemplate' =>'<a href="{url}">{icon} {label} {badge}</a>',
                        'items' => $menuItems,
                    ]);
                    ?>
      
      
     
      
    </div>
</div>

                <?php echo $content; ?>
         

<?php $this->endContent(); ?>
