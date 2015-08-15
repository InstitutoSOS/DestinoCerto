<?php
namespace backend\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\rest\ActiveController;


/**
 * PackageController implements the CRUD actions for Package model.
 */
class BaseController extends Controller
{
    public $modelClass = 'common\models\Material';

    public function beforeAction()
    {      
        // if ($this->action->id == 'index') {
        Yii::$app->controller->enableCsrfValidation = false;
        // }
        return true;
    }

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'index' => ['get'],
                    'view' => ['get'],
                    'create' => ['post'],
                    'update' => ['put'],
                    'delete' => ['delete'],
                ],
            ],
        ];
    }

    public function actionError()
    {
        Yii::$app->response->format = 'json';
        Yii::$app->response->setStatusCode(404);
        return ['message' => 'Route not defined', 'success' => false];
    }
}
