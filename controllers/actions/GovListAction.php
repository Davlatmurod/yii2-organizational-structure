<?php

namespace andahrm\structure\controllers\actions;

use Yii;

/**
 * Class for saving translations.
 * @author Lajos Molnár <lajax.m@gmail.com>
 * @since 1.0
 */
class GovListAction extends \yii\base\Action {

  public $key ;
    /**
     * Saving translated language elements.
     * @return Json
     */
    public function run() {
      $this->controller->layout = 'base-salary';
      return $this->controller->render('gov-list',[
        'key'=>$this->key
      ]);
    }

}
