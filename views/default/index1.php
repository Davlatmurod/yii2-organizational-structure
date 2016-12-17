<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel andahrm\structure\models\PositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Positions');
$this->params['breadcrumbs'][] = $this->title;



andahrm\structure\assets\JqueryOrg::register($this);

//print_r(\andahrm\structure\models\Position::getList());
?>
        <div id="content">

            <div id="mainOrg">
              
               <ul id="organisation">
                <li><adjunct>Alfred</adjunct><em>Batman</em>
                    <ul>
                        <li>Batman Begins<br/>
                            <ul>
                                <li>Ra's Al Ghul</li>
                                <li>Carmine Falconi</li>
                            </ul>
                        </li>
                        <li>The Dark Knight<br/>
                            <ul>
                                <li>Joker</li>
                                <li>Harvey Dent</li>
                            </ul>
                        </li>
                        <li>The Dark Knight Rises<br/>
                            <ul>
                                <li>Bane</li>
                                <li>Talia Al Ghul</li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
            </div>

        </div>


<?php


$this->registerJs('
    $(function() {
            $("#organisation").orgChart({
              container: $("#mainOrg"),
              interactive: true,
              fade: true,
              speed: "slow"
            });
    });
');


