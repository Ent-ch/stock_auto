<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class BaseController extends Controller
{
	public function init()
	{
		if (Yii::$app->user->isGuest){
			return $this->redirect(['/user/login']);
		}
	}
}
