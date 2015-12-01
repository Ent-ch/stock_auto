<?php

namespace app\controllers;

use Yii;
use app\models\CarStatusSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class StatusController extends BaseController
{
    public function actionIndex()
    {
        $searchModel = new CarStatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => Yii::t('app', 'Cars on road'),
        ]);

    }

	public function actionCustum()
    {
        $searchModel = new CarStatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => Yii::t('app', 'Cars on custum'),
        ]);

    }

	public function actionDistr()
    {
        $searchModel = new CarStatusSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'title' => Yii::t('app', 'Cars on distr'),
        ]);

    }

}
