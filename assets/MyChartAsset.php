<?php 
namespace andahrm\structure\assets; 
use yii\web\AssetBundle; 


class MyChartAsset extends AssetBundle { 
    public $sourcePath = '@andahrm/structure/assets'; //กำหนดที่เก็บ Asset(css,js,image) 
    public $css = [  //กำหนดลงทะเบียนไฟล์ css 
      'style-orgchart.css', 
    ]; 
    //public $cssOptions = ['position' => \yii\web\View::POS_HEAD];
  
    public $js = [ //กำหนดลงทะเบียนไฟล์ javascript 
    ]; 

    public $depends = [ //กำหนดให้ลงทะเบียนหลังจาก Asset เหล่านี้ 
      'firdows\orgchart\OrgChartAsset',
    ]; 
  
    public $publishOptions = ['forceCopy' => true];
}