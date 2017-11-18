<?php
use yii\bootstrap\Html;
//use yii\widgets\Menu;
use yii\bootstrap\Nav;
use dmstr\widgets\Menu;
use mdm\admin\components\Helper;

 $this->beginContent('@andahrm/structure/views/layouts/tab.php'); 
 $module = $this->context->module->id;
 $controller = $this->context->id;
?>

<?php echo $content; ?>

<?php $this->endContent(); ?>
