<?php

namespace andahrm\structure\controllers;

use Yii;
use andahrm\structure\models\Position;
use andahrm\structure\models\PositionSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;
use andahrm\structure\models\PositionLine;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * PositionController implements the CRUD actions for Position model.
 */
class PositionController extends Controller
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
     * Lists all Position models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new PositionSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        $dataProvider->sort->defaultOrder = [
            'person_type_id'=>SORT_ASC,
            'section_id'=>SORT_ASC,
            'position_line_id'=>SORT_ASC,
            'number'=>SORT_ASC,
        ];

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Position model.
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
     * Creates a new Position model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Position(['scenario'=>'insert']);

        if ($model->load(Yii::$app->request->post())){
            //echo $model->person_type_id.'-'.$model->section_id.'-'.$model->position_line_id.'-'.$model->number;
            if (Yii::$app->request->isAjax) {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $valid = ActiveForm::validate($model);
        if($model->getExists())
        $valid['position-number'] = [Yii::t('andahrm/structure', 'This sequence already exists.')];
        return $valid; 
        Yii::$app->end();

    }
            
            //print_r(Yii::$app->request->post());
            //exit();
            if($model->save()) {
            Yii::$app->getSession()->setFlash('saved',[
                'type' => 'success',
                'msg' => Yii::t('andahrm', 'Save operation completed.')
            ]);
            return $this->redirect(['view', 'id' => $model->id]);
            }
        } 
        return $this->render('create', [
            'model' => $model,
        ]);
        
    }

    /**
     * Updates an existing Position model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->scenario = 'update';

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
     * Deletes an existing Position model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);
        $model->status = Position::STASUS_CLOSE;
        $model->save();
        return $this->redirect(['index']);
    }

    /**
     * Finds the Position model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Position the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Position::findOne($id)) !== null) {
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
  
    public function actionGetPositionLine() {
     $out = [];
      $post = Yii::$app->request->post();
     if ($post['depdrop_parents']) {
         $parents = $post['depdrop_parents'];
         if ($parents != null) {
             $person_type_id = $parents[0];
             $out = $this->getPositionLine($person_type_id);
             echo Json::encode(['output'=>$out, 'selected'=>'']);
             return;
         }
         }
         echo Json::encode(['output'=>'', 'selected'=>'']);
     }

      protected function getPositionLine($id){
         $datas = PositionLine::find()->where(['person_type_id'=>$id])->all();
         return $this->MapData($datas,'id','titleCode');
     }
     
     public $code;
     public function actionPositionList($q = null, $id = null){
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON; //กำหนดการแสดงผลข้อมูลแบบ json
        $out = ['results'=>['id'=>'','text'=>'']];
        if(!is_null($q)){
            // $query = new \yii\db\Query();
            // $query->select('id, prefix_name as text')
            //         ->from('base_prefix')
            //         ->where("prefix_name LIKE '%".$q."%'")
            //         ->limit(20);
            // $command = $query->createCommand();
            // $data = $command->queryAll();
            
          
            $this->code = $q;
            $model = Position::find();
            //$model->select(['position.id','position.code as text']);
            if($this->code){
                $code = explode('-',$this->code);
                if($code[0]=='46'){
                    $personTypeCode = $code[0].(isset($code[1])?'-'.$code[1]:'');
                    $sectionCode = isset($code[2])?$code[2]:null;
                    $positionLineCode = isset($code[3])?$code[3]:null;
                    $number = isset($code[4])?$code[4]*1:null;
                    }else{
                    $personTypeCode = $code[0];
                    $sectionCode = isset($code[1])?$code[1]:null;
                    $positionLineCode = isset($code[2])?$code[2]:null;
                    $number = isset($code[3])?$code[3]*1:null;
                }
                
               $model->joinWith("personType");
               $model->andFilterWhere(['like', 'person_type.code', $personTypeCode]);
               
               $model->joinWith("section");
               $model->andFilterWhere(['like', 'section.code', $sectionCode]);
               
               $model->joinWith("positionLine");
               $model->andFilterWhere(['like', 'position_line.code', $positionLineCode]);
               
               $model->andFilterWhere(['like', 'number', $number]);
               //$model->asArray()->all();
        }
        
            $out['results'] = ArrayHelper::getColumn($model->all(),function($model){
                return ['id'=>$model->id,'text'=>$model->code];
            });
        }
        return $out;
    }
  
}
