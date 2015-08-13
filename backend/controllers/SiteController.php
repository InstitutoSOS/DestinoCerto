<?php

namespace backend\controllers;

use Yii;
use common\models\Site;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * SiteController implements the CRUD actions for Site model.
 */
class SiteController extends BaseController
{
    /**
     * Lists all Site models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => Site::find(),
        ]);

        $data = Site::find()->all();
        return Json::encode($data);
    }

    /**
     * Displays a single Site model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $data = $this->findModel($id);
        return Json::encode($data);
    }

    /**
     * Creates a new Site model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Site();

        $arr['Site'] = Yii::$app->request->post();
        if ($model->load($arr) && $model->save()) {
            return Json::encode($model);
        } else {
            return Json::encode(['message' => 'Record cound\'t be saved']);
        }
    }

    /**
     * Updates an existing Site model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $arr['Site'] = Yii::$app->request->post();
        if ($model->load($arr) && $model->save()) {
            return Json::encode($model);
        } else {
            return Json::encode(['message' => 'Record cound\'t be saved']);
        }
    }

    /**
     * Deletes an existing Site model.
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
     * Finds the Site model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Site the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Site::findOne($id)) !== null) {
            return $model;
        } else {
            return ['message' => 'Record not found'];
        }
    }
}
