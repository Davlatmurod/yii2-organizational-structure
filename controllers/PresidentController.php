<?php

namespace andahrm\structure\controllers;

use Yii;
use andahrm\structure\models\President;
use andahrm\structure\models\PresidentSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PresidentController implements the CRUD actions for President model.
 */
class PresidentController extends Controller {

    /**
     * @inheritdoc
     */
    public function behaviors() {
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
     * Lists all President models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new PresidentSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single President model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($user_id, $start_date) {
        return $this->render('view', [
                    'model' => $this->findModel($user_id, $start_date),
        ]);
    }

    /**
     * Creates a new President model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        $model = new President();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            President::updateActive($model->user_id, $model->start_date);
            return $this->redirect(['view', 'user_id' => $model->user_id,'start_date'=>$model->start_date]);
        }

        return $this->render('create', [
                    'model' => $model,
        ]);
    }

    /**
     * Updates an existing President model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($user_id, $start_date) {
        $model = $this->findModel($user_id, $start_date);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            President::updateActive($model->user_id, $model->start_date);
            return $this->redirect(['view', 'user_id' => $model->user_id,'start_date'=>$model->start_date]);
        }

        return $this->render('update', [
                    'model' => $model,
        ]);
    }

    /**
     * Deletes an existing President model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($user_id, $start_date) {
        $this->findModel($user_id, $start_date)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the President model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return President the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($user_id, $start_date) {
        if (($model = President::findOne(['user_id' => $user_id, 'start_date' => $start_date])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('andahrm/structure', 'The requested page does not exist.'));
    }

}
