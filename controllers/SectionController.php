<?php

namespace andahrm\structure\controllers;

use Yii;
use andahrm\structure\models\Section;
use andahrm\structure\models\SectionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * SectionController implements the CRUD actions for Section model.
 */
class SectionController extends Controller
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
     * Lists all Section models.
     * @return mixed
     */
    public function actionIndex()
    {
        /*$searchModel = new SectionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);*/
      
       $treeArray = Section::find()->dataFancytree();
        return $this->render('index', ['treeArray' => $treeArray]);
    }
  
  public function actionMoveNode($id, $mode, $targetId)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = $this->findModel($id);
            $target = $this->findModel($targetId);
            switch ($mode){
                case 'over': $model->moveAsLast($target);
                    break;
                case 'before': $model->moveBefore($target);
                    break;
                case 'after': $model->moveAfter($target);
                    break;
            }
            $result = ['process' => true, 'message' => 'Move '.$model->id.' to '.$target->id.' has success..', 'mode' => $mode];
            echo \yii\helpers\Json::encode($result);
            return;
            //return $this->redirect(['tree', 'id' => $model->id]);
        }
    }
  

    /**
     * Displays a single Section model.
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
     * Creates a new Section model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parent_id=null)
    {
        $model = new Section();
        $treeArray = Section::find()->dataFancytree();

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if (Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if($parent_id === null){
                $model->saveNode();
            }else{
                $root = $this->findModel(intval($parent_id));
                $model->appendTo($root);
            }
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            if (Yii::$app->request->isAjax){
                return $this->renderAjax('create', [
                    'model' => $model,
                    'treeArray' => $treeArray,
                ]);
            }
            return $this->render('create', [
                'model' => $model,
                'treeArray' => $treeArray,
            ]);
        }
    }
  /*
  
    public function actionCreate()
    {
        $model = new Section();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }
*/
    /**
     * Updates an existing Section model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
   public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if (Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            $model->saveNode();
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            if(Yii::$app->request->isAjax){
                return $this->renderAjax('update', [
                    'model' => $model,
                ]);
            }
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

  
  
  public function actionTree($id=null, $mode=null, $targetId=null)
    {
        if (Yii::$app->request->isAjax && $id !== null) {
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $model = $this->findModel($id);
            $target = $this->findModel($targetId);
            switch ($mode){
                case 'over': $model->moveAsLast($target);
                    break;
                case 'before': $model->moveBefore($target);
                    break;
                case 'after': $model->moveAfter($target);
                    break;
            }
            $result = ['process' => true, 'message' => 'Move '.$model->id.' to '.$target->id.' has success..', 'mode' => $mode];
            echo \yii\helpers\Json::encode($result);
            return;
            //return $this->redirect(['tree', 'id' => $model->id]);
        }
        $treeArray = Section::find()->dataFancytree();
        return $this->render('tree', ['treeArray' => $treeArray]);
    }
    /**
     * Deletes an existing Section model.
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
     * Finds the Section model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Section the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Section::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
