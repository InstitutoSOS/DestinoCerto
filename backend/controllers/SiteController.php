<?php

namespace backend\controllers;

use Yii;
use common\models\Site;
use common\models\Package;
use common\models\LocationHistory;
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
        Yii::$app->response->format = 'json';
        return $data;
    }

    /**
     * Displays a single Site model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        Yii::$app->response->format = 'json';
        $model = Site::find()->where(['site.id' => $id])
            ->select(['site.*', 'package.*', 'material.*'])
            ->innerJoin('location_history')
            ->innerJoin('package')
            ->innerJoin('material')
            ->asArray()
            ->one();
        $response = [];
        $model = Site::find()->where(['site.id' => $id])->asArray()->one();


        $packages = LocationHistory::find()
            ->where(['site_id' => $model['id']])
            ->orderBy('timestamp DESC')
            ->groupBy('package_id')
            ->asArray()
            ->all();

        $response[] = $model;
        $response['materials'] = [];
        foreach ($packages as $key => $value) :
            $package = Package::find()->with('material')->asArray()->one();

            $response['materials'][strtolower($package['material']['name'])] = [
                'weight' => $package['weight'],
            ];
        endforeach;


        // $model = \yii\helpers\ArrayHelper::map($model, '');
        return $response;
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
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(201);
            return $model;
        } else {
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(400);
            return ['message' => 'Record cound\'t be saved'];
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
        Yii::$app->response->format = 'json';
        $model = $this->findModel($id);

        $arr['Site'] = Yii::$app->request->post();
        if ($model->load($arr)) {
            if ($model->save())
                return $model;
        } else {
            return ['message' => 'Record cound\'t be saved'];
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
        Yii::$app->response->format = 'json';
        if($this->findModel($id)->delete())
            return ['message' => 'Record deleted'];
        else
            return ['message' => 'Record cound\'t be deleted'];

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
        $model = Site::find()->where(['id' => $id])
            ->with('materials')
            ->one();

        if ($model !== null) 
        {
            return $model;
        } else {
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(404);
            return ['message' => 'Record not found'];
            die();
        }
    }
}
