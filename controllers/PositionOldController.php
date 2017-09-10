<?php

namespace andahrm\structure\controllers;

use Yii;
use andahrm\structure\models\PositionOld;
use andahrm\structure\models\PositionOldSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * PositionOldController implements the CRUD actions for PositionOld model.
 */
class PositionOldController extends Controller
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
    
    
    public function actions()
    {
        $this->layout = 'position';
    }

    /**
     * Lists all PositionOld models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PositionOldSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single PositionOld model.
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
     * Creates a new PositionOld model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new PositionOld();

        if ($model->load(Yii::$app->request->post())){
            
            if (Yii::$app->request->isAjax) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                $valid = ActiveForm::validate($model);
                if($model->getExists())
                $valid['position-number'] = [Yii::t('andahrm/structure', 'This sequence already exists.')];
                return $valid; 
                Yii::$app->end();
            }
            
            
            if($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } 
        }
            return $this->render('create', [
                'model' => $model,
            ]);
        
    }
    
     public function actionCreateAjax($formAction = null)
    {
        $model = new PositionOld();

        if(Yii::$app->request->isPost){
             Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            
           
            $success = false;
            $result=null;
            
            $request = Yii::$app->request;
            $post = Yii::$app->request->post();
            
            if (Yii::$app->request->isAjax && $model->load($post) && $request->post('ajax')) {
                return ActiveForm::validate($model); 
            }elseif($request->post('save') && $model->load($post)){
                if($model->save()) {
                    $success = true;
                    $result = $model->attributes;
                }else{
                    $result = $model->getErrors();
                    print_r($post);
            exit();
                }
                return ['success' => $success, 'result' => $result];
            }
            
        }else{
            
        return $this->renderPartial('_form', [
            'model' => $model,
            'formAction' => $formAction
        ]);
        }
        
    
    }

    /**
     * Updates an existing PositionOld model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing PositionOld model.
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
     * Finds the PositionOld model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PositionOld the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = PositionOld::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    // public function actionPositionList($q = null, $id = null){
    //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; //กำหนดการแสดงผลข้อมูลแบบ json
    //     $out = ['results'=>['id'=>'','text'=>'']];
    //     if(!is_null($q)){
    //         $model = PositionOld::find()->where(['like','code',$q])->orderBy('code');
    //         $out['results'] = ArrayHelper::getColumn($model->all(),function($model){
    //             return ['id'=>$model->id,'text'=>$model->code];
    //         });
    //     }
    //     return $out;
    // }
    
    //  public function actionPositionList($q = null, $id = null){
    //     Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; //กำหนดการแสดงผลข้อมูลแบบ json
    //     //$out = ['results'=>['id'=>'','text'=>'']];
    //     $data = PositionOld::find()->andFilterWhere(['like','code',$q])->all();
    //     $out = [];
    //     foreach ($data as $model) {
    //         $out[] = ['value' => $model->codeTitle];
    //     }
    //     echo Json::encode($out);
    // }
    
    public function actionPositionList($q = null, $id = null){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; //กำหนดการแสดงผลข้อมูลแบบ json
        $out = ['results'=>['id'=>'','text'=>'']];
        if(!is_null($q)){
            //$this->code = $q;
            $model = PositionOld::find();
            $model->andFilterWhere(['like', 'code',  $q]);
            $model->orFilterWhere(['like', 'title',  $q]);
            $out['results'] = ArrayHelper::getColumn($model->all(),function($model){
                return ['id'=>$model->id,'text'=>$model->codeTitle];
            });
        }
        return $out;
    }
    
}
