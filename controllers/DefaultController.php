<?php

namespace andahrm\structure\controllers;

use Yii;
use andahrm\structure\models\Structure;
use andahrm\structure\models\StructureSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;
use yii\web\Response;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;

use andahrm\structure\models\Position;
use andahrm\structure\models\PositionSearch;
use andahrm\structure\models\StructurePosition;

use yii\helpers\Json;

/**
 * DefaultController implements the CRUD actions for Structure model.
 */
class DefaultController extends Controller
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
     * Lists all Structure models.
     * @return mixed
     */
    public function actionIndex()
    {
        $this->layout = 'org';
        $treeArray = Structure::find()->dataFancytree();
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
     * Displays a single Structure model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        
        $dataProvider = new ArrayDataProvider([
            'allModels'=>$model->structurePositions,
            ]);
        
        if(Yii::$app->request->isAjax){
            return $this->renderAjax('view', [
                'model' => $model,
                'dataProvider'=>$dataProvider,
            ]);
        }
        return $this->render('view', [
            'model' => $model,
            'dataProvider'=>$dataProvider,
        ]);
    }

    /**
     * Creates a new Structure model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($parent_id=null)
    {
        $model = new Structure();
        $treeArray = Structure::find()->dataFancytree();

        $post = Yii::$app->request->post();
      
        //StructurePosition
        if ($model->load($post)) {
            if (Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if($parent_id === null){
                $model->saveNode();
                Yii::$app->getSession()->setFlash('clear',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm/setting', 'Clear assets completed.')
                ]);
            }else{ //Child
                $root = $this->findModel(intval($parent_id));
                $model->appendTo($root);
            }
          if($model->id){
            StructurePosition::deleteAll(['structure_id'=>$model->id]);
            
            if(isset($post['selection'])){
                    foreach($post['selection'] as $position_id){
                      $modelStructurePosition = new StructurePosition();
                      $modelStructurePosition->structure_id = $model->id;
                      $modelStructurePosition->position_id = $position_id;
                      if(!$modelStructurePosition->save(false)){
                          print_r($modelStructurePosition->getErrors());
                          exit();
                      }
                   }
               }
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
            if($model->saveNode()){
          
               if($model->id){
                    StructurePosition::deleteAll(['structure_id'=>$model->id]);

                   if(isset($post['selection'])){
                        foreach($post['selection'] as $position_id){
                          $modelStructurePosition = new StructurePosition();
                          $modelStructurePosition->structure_id = $model->id;
                          $modelStructurePosition->position_id = $position_id;
                          if(!$modelStructurePosition->save(false)){
                              print_r($modelStructurePosition->getErrors());
                              exit();
                          }
                       }
                   }
                }
                
              
              Yii::$app->getSession()->setFlash('clear',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm/setting', 'Clear assets completed.')
                ]);
            }  
          
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
        //$this->findModel($id)->delete();
        if($model = Structure::findOne($id)){
            $model->delete();
        }

        return $this->redirect(['index']);
    }

    /**
     * Finds the Structure model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Structure the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Structure::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
     public function actionGetPosition($section_id,$position_line_id=null,$structure_id=null,$position_id=null)
    {
      
        $query = Position::find()
          //->joinWith('structurePositions')
          //->leftJoin('structure_position', 'structure_position.position_id = position.id')
          //->select('structure_position.structure_id as structure_id')
          ->where([
          'section_id' => $section_id,
        ]);
        $query = $query->andFilterWhere(['position_line_id' => $position_line_id]);
        
      //$selected = StructurePosition::find()->select(['position_id'])->where(['structure_id'=>$id])->all();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            //'selected'=> $selected
        ]);
//       echo "<pre>";
//       print_r($dataProvider);
//       exit();
      
      if(Yii::$app->request->isAjax){
        return $this->renderAjax('get-position', [
            'dataProvider' => $dataProvider,
            'structure_id'=>$structure_id
        ]);
      }else{
         return $this->renderPartial('get-position', [
            'dataProvider' => $dataProvider,
            'structure_id'=>$structure_id
        ]);
      }
    }
    
    
    public function actionOrg(){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        echo "<pre>";
//        print_r(Structure::getOrgJson());
//        exit();
        return Structure::getOrgJson();
        
        
    }
    
    public function actionAddPosition($id){
        
        $model = $this->findModel($id);

        $post = Yii::$app->request->post();
        if ($model->load($post)) {
            if (Yii::$app->request->isAjax){
                Yii::$app->response->format = Response::FORMAT_JSON;
                return ActiveForm::validate($model);
            }
            if($model->saveNode()){
          
               if($model->id){
                    StructurePosition::deleteAll(['structure_id'=>$model->id]);

                   if(isset($post['selection'])){
                        foreach($post['selection'] as $position_id){
                          $modelStructurePosition = new StructurePosition();
                          $modelStructurePosition->structure_id = $model->id;
                          $modelStructurePosition->position_id = $position_id;
                          if(!$modelStructurePosition->save(false)){
                              print_r($modelStructurePosition->getErrors());
                              exit();
                          }
                       }
                   }
                }
                
              
              Yii::$app->getSession()->setFlash('clear',[
                    'type' => 'success',
                    'msg' => Yii::t('andahrm/setting', 'Clear assets completed.')
                ]);
            }  
          
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            
            return $this->renderPartial('add_position', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionUpdatePosition($id,$position_id,$mode=''){
        
        $model = $this->findModel($id);

        if($mode=='add'){
            $modelStruct = new StructurePosition(['structure_id'=>$id,'position_id'=>$position_id]);
            $modelStruct->save(false);
        }elseif($mode == 'del'){
            if($modelStruct = StructurePosition::find()->where(['structure_id'=>$id,'position_id'=>$position_id])->one()){
               // print_r($modelStruct);
                $modelStruct->delete();
            }
        }
        
        return $this->redirect(['index', 'id' => $model->id]);
        
    }
    
}
