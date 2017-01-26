<?php 
namespace andahrm\structure\assets; 
use yii\web\AssetBundle; 


class JqueryOrg extends AssetBundle { 
    public $sourcePath = '@andahrm/structure/assets/jquery-orgchart'; //กำหนดที่เก็บ Asset(css,js,image) 
    public $css = [  //กำหนดลงทะเบียนไฟล์ css 
      'jquery.orgchart.css', 
      'style.css', 
    ]; 
    //public $cssOptions = ['position' => \yii\web\View::POS_HEAD];
  
    public $js = [ //กำหนดลงทะเบียนไฟล์ javascript 
      'jquery.orgchart.min.js', 
    ]; 

    public $depends = [ //กำหนดให้ลงทะเบียนหลังจาก Asset เหล่านี้ 
      'yiister\gentelella\assets\ThemeAsset',
    ]; 
  
    public $publishOptions = ['forceCopy' => true];
}