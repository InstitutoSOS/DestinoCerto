<?php

namespace backend\controllers;

use Yii;
use common\models\LocationHistory;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * LocationHistoryController implements the CRUD actions for LocationHistory model.
 */
class LocationhistoryController extends BaseController
{

    public $modelClass = 'common\models\LocationHistory';

    /**
     * Lists all LocationHistory models.
     * @return mixed
     */
    public function actionIndex()
    {

        $data = LocationHistory::find()->with('package', 'site')->asArray()->all();
        return Json::encode($data);
    }

    /**
     * Displays a single LocationHistory model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $data = $this->findModel($id);
        return Json::encode($data);
    }

    /**
     * Creates a new LocationHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        Yii::$app->response->format = 'json';

        $model = new LocationHistory();
        $arr['LocationHistory'] = Yii::$app->request->post();
        if ($model->load($arr)) {
            $model->package_id = $arr['LocationHistory']['package_id'];
            Yii::$app->response->setStatusCode(201);
            if($model->save())
                return $model;
        } else {
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(400);
            return ['message' => 'Record cound\'t be saved'];
        }
    }

    /**
     * Updates an existing LocationHistory model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $arr['LocationHistory'] = Yii::$app->request->post();
        if ($model->load($arr) && $model->save()) {
            return Json::encode($model);
        } else {
            return Json::encode(['message' => 'Record cound\'t be saved']);
        }
    }

    /**
     * Deletes an existing LocationHistory model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        if($this->findModel($id)->delete())
            return Json::encode(['message' => 'Record deleted']);
        else
            return Json::encode(['message' => 'Record cound\'t be deleted']);

        return $this->redirect(['index']);
    }

    /**
     * Finds the LocationHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return LocationHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = LocationHistory::find()->where(['id' => $id])->with('package', 'site')->asArray()->one()) !== null) {
            return $model;
        } else {
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(404);
            Yii::$app->response->data = ['message' => 'Record not found'];
            Yii::$app->response->send();
        }
    }
}
