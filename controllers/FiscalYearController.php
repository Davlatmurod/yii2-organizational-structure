<?php

namespace andahrm\structure\controllers;

use Yii;
use andahrm\structure\models\FiscalYear;
use andahrm\structure\models\FiscalYearSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use yii\helpers\Json;
use yii\helpers\ArrayHelper;
/**
 * FiscalYearController implements the CRUD actions for FiscalYear model.
 */
class FiscalYearController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all FiscalYear models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FiscalYearSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FiscalYear model.
     * @param string $year
     * @param integer $phase
     * @return mixed
     */
    public function actionView($year, $phase)
    {
        return $this->render('view', [
            'model' => $this->findModel($year, $phase),
        ]);
    }

    /**
     * Creates a new FiscalYear model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FiscalYear();
        
        // print_r(Yii::$app->request->post());
        // exit();
        if ($model->load(Yii::$app->request->post())){
            
            if($this->findModel($model->year, $model->phase)){
                $model->addError('year','มีปีนี้อยู่แล้ว');
                $model->addError('phase','มีภาคอยู่แล้ว');
            }
            
            if(!$model->hasErrors() && $model->save()) {
                return $this->redirect(['view', 'year' => $model->year, 'phase' => $model->phase]);
            }
        } 
            return $this->render('create', [
                'model' => $model,
            ]);
        
    }

    /**
     * Updates an existing FiscalYear model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $year
     * @param integer $phase
     * @return mixed
     */
    public function actionUpdate($year, $phase)
    {
        $model = $this->findModel($year, $phase);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'year' => $model->year, 'phase' => $model->phase]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FiscalYear model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $year
     * @param integer $phase
     * @return mixed
     */
    public function actionDelete($year, $phase)
    {
        $this->findModel($year, $phase)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FiscalYear model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $year
     * @param integer $phase
     * @return FiscalYear the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($year, $phase)
    {
        if (($model = FiscalYear::findOne(['year' => $year, 'phase' => $phase])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
    
    ####################################################################
    protected function MapData($datas,$fieldId,$fieldName){
     $obj = [];
     foreach ($datas as $key => $value) {
         array_push($obj, ['id'=>$value->{$fieldId},'name'=>$value->{$fieldName}]);
     }
     return $obj;
    }
 
    ###############
     public function actionGetPhase() {
     $out = [];
      $post = Yii::$app->request->post();
     if ($post['depdrop_parents']) {
         $parents = $post['depdrop_parents'];
         if ($parents != null) {
             $year = $parents[0];
             $out = $this->getPhase($year);
             echo Json::encode(['output'=>$out, 'selected'=>'']);
             return;
         }
         }
         echo Json::encode(['output'=>'', 'selected'=>'']);
     }

      protected function getPhase($year){
         $datas = FiscalYear::find()->where(['year'=>$year])->all();
         return $this->MapData($datas,'phase','phaseTitle');
     }
}
