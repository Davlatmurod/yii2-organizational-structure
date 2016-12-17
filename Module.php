<?php

namespace andahrm\structure;
use Yii;

/**
 * structure module definition class
 */
class Module extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'andahrm\structure\controllers';

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
        $this->setLayout();
        
        $this->registerTranslations();
    }
  
  /**
     * Set Layout
     */
    private function setLayout()
    {
        $this->layoutPath = '@andahrm/structure/views/layouts';
        $this->layout = 'main';
    }

    public function registerTranslations()
    {      
        Yii::$app->i18n->translations['andahrm/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@andahrm/structure/messages',
            'fileMap' => [
                'andahrm/structure' => 'structure.php',
            ]
        ];
    }
  
  
}
