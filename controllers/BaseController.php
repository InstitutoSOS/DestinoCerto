<?php 
use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

class BaseController extends Controller
{
	
	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'create' => ['post'],
                    'update' => ['put'],
                    'delete' => ['delete'],
                ],
            ],
        ];
    }
}