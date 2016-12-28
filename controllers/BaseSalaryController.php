<?php

namespace andahrm\structure\controllers;

use Yii;
use andahrm\structure\models\BaseSalary;
use andahrm\structure\models\BaseSalarySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use andahrm\structure\models\PositionType;
use andahrm\structure\models\PositionLevel;
use yii\web\Response;

use andahrm\structure\models\PersonType;

/**
 * BaseSalaryController implements the CRUD actions for BaseSalary model.
 */
class BaseSalaryController extends Controller
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
  
  public function actions() {       
    $actions = [];
    $actions['person-type1'] =  [
                'class' => 'andahrm\structure\controllers\actions\GovListAction',
                'key' => 1
        ];
    
     foreach(PersonType::getList() as $key => $type){
       if($key==1) continue;
        $actions['person-type'.$key] =   [
                'class' => 'andahrm\structure\controllers\actions\GovListAction',
                'key' =>$key
        ];
      }
    
//     print_r($actions);
//     exit();
    
    
        return $actions;
    }

    /**
     * Lists all BaseSalary models.
     * @return mixed
     */
    public function actionIndex()
    {
      $this->layout = 'base-salary';
        $searchModel = new BaseSalarySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BaseSalary model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new BaseSalary model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new BaseSalary();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing BaseSalary model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
             Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing BaseSalary model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the BaseSalary model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return BaseSalary the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BaseSalary::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
  
   protected function MapData($datas,$fieldId,$fieldName){
     $obj = [];
     foreach ($datas as $key => $value) {
         array_push($obj, ['id'=>$value->{$fieldId},'name'=>$value->{$fieldName}]);
     }
     return $obj;
 }
  
    public function actionGetPositionType() {
     $out = [];
      $post = Yii::$app->request->post();
     if ($post['depdrop_parents']) {
         $parents = $post['depdrop_parents'];
         if ($parents != null) {
             $person_type_id = $parents[0];
             $out = $this->getPositionType($person_type_id);
             echo Json::encode(['output'=>$out, 'selected'=>'']);
             return;
         }
         }
         echo Json::encode(['output'=>'', 'selected'=>'']);
     }

      protected function getPositionType($id){
         $datas = PositionType::find()->where(['person_type_id'=>$id])->all();
         return $this->MapData($datas,'id','title');
     }
  
    public function actionGetPositionLevel() {
     $out = [];
      $post = Yii::$app->request->post();
     if ($post['depdrop_parents']) {
         $parents = $post['depdrop_parents'];
         if ($parents != null) {
             $position_type_id = $parents[0];
             $out = $this->getPositionLevel($position_type_id);
             echo Json::encode(['output'=>$out, 'selected'=>'']);
             return;
         }
         }
         echo Json::encode(['output'=>'', 'selected'=>'']);
     }

      protected function getPositionLevel($id){
         $datas = PositionLevel::find()->where(['position_type_id'=>$id])->all();
         return $this->MapData($datas,'id','title');
     }
  
  
  public function actionSave()
    {
      
      Yii::$app->response->format = Response::FORMAT_JSON;
        
        $post = Yii::$app->request->post();
        $person_type_id = '';
        $position_type_id = '';
        $position_level_id = '';
      
        $model = [];
        if($post['id']){
          $model = BaseSalary::find()
          ->where(['id'=>$post['id']])
          ->one();
        }else{
          $key = explode('-',$post['key']);  
          $person_type_id = $key[0];
          $position_type_id = $key[1];
          $position_level_id = isset($key[2])?$key[2]:null;
          $model = new BaseSalary();
        }
       
      if($model->isNewRecord){        
        $model->person_type_id=$person_type_id;
        $model->position_type_id=$position_type_id;
        $model->position_level_id=$position_level_id;
        $model->step=$post['step'];
        $model->salary=$post['val'];
      }else{       
        $model->salary=$post['val'];
      }

        if ($model->validate() && $model->save()) {
            Yii::$app->getSession()->setFlash('saved',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm', 'Save operation completed.')
            ]);
            return ['success'=>1];
          //return $this->render('gov-list',['key'=>$model->person_type_id]);
        } 
        //print_r($model->getErrors());
        return $model->getErrors();
    }
  
}
