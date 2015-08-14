<?php

namespace backend\controllers;

use Yii;
use common\models\User;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends BaseController
{
    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find(),
        ]);

        $data = User::find()->all();
        return Json::encode($data);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $data = $this->findModel($id);
        return Json::encode($data);
    }

    public function actionLogin()
    {
        $post = Yii::$app->request->post();

        Yii::$app->response->format = 'json';
        $model = User::find()->where(['username' => $post['username']])->one();
        if ($model == null) {
            return ['message' => 'User not found', 'status' => false, 'userExists' => false];
        } elseif (Yii::$app->security->validatePassword($post['password'], $model->password)) {
            $response = [];
            $response['success'] = true;
            $response['userExists'] = true;
            $response['model'] = $model;
            return $response;
        } else {
            Yii::$app->response->setStatusCode(404);
            return ['message' => 'Password Incorrect', 'success'=>false, 'userExists' => true];
        }




    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new User();

        $arr['User'] = Yii::$app->request->post();
        Yii::$app->response->format = 'json';
        if ($model->load($arr)) {
            if($model->save()){
                Yii::$app->response->setStatusCode(201);
                return $model;
            } else {
                return ['message' => 'Rcords couldn\'t be lodead saved'];
            }
        } else {
            Yii::$app->response->setStatusCode(400);
            return ['message' => 'Record cound\'t be saved'];
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $arr['User'] = Yii::$app->request->post();
        if ($model->load($arr)) {
            if($model->save())
                return Json::encode($model);
        } else {
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(400);
            Yii::$app->response->data = ['message' => 'Record cound\'t be saved'];
            Yii::$app->response->send();
        }
    }

    /**
     * Deletes an existing User model.
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
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        } else {
            Yii::$app->response->format = 'json';
            Yii::$app->response->setStatusCode(404);
            Yii::$app->response->data = ['message' => 'Record not found'];
            Yii::$app->response->send();
            die();
        }
    }
}
