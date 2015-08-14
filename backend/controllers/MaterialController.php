<?php

namespace backend\controllers;

use Yii;
// use yii\data\ActiveDataProvider;
use common\models\Material;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\rest\ActiveController;

/**
 * MaterialController implements the CRUD actions for Material model.
 */
class MaterialController extends BaseController
{

    public $modelClass = 'common\models\Material';

    /**
     * Lists all Material models.
     * @return mixed
     */
    public function actionIndex()
    {
        $data = Material::find()->all();
        return Json::encode($data);
    }

    /**
     * Displays a single Material model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $data = $this->findModel($id);
        return Json::encode($data);
    }

    /**
     * Creates a new Material model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Material();
        $arr['Material'] = Yii::$app->request->post();
        if ($model->load($arr) && $model->save()) {
            return Json::encode($model);
        } else {
            return Json::encode(['message' => 'Record cound\'t be saved', 'errors' => $model->errors]);
        }
    }

    /**
     * Updates an existing Material model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $arr['Material'] = Yii::$app->request->post();
        if ($model->load($arr) && $model->save()) {
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(201);
            Yii::$app->response->data = $model;
            Yii::$app->response->send();
        } else {
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(400);
            Yii::$app->response->data = ['message' => 'Record cound\'t be saved'];
            Yii::$app->response->send();
        }
    }

    /**
     * Deletes an existing Material model.
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
     * Finds the Material model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Material the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Material::find()->where(['id' => $id])->with('sites')->asArray()->one()) !== null) {
            return $model;
        } else {
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(404);
            Yii::$app->response->data = ['message' => 'Record not found'];
            Yii::$app->response->send();
        }
    }
}
