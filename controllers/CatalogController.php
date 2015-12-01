<?php

namespace app\controllers;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\models\CatalogSearch;

class CatalogController extends BaseController
{
	public $modelName = 'app\models\Catalog';
	public $modelTitle = 'Plants';
	
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel = new CatalogSearch();
        $dataProvider = $searchModel->search($this->modelName, Yii::$app->request->queryParams);

        return $this->render('/catalog/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelTitle' => $this->modelTitle,
        ]);
		
/*        $dataProvider = new ActiveDataProvider([
            'query' => call_user_func([$this->modelName , 'find']),
        ]);

        return $this->render('/catalog/index', [
            'dataProvider' => $dataProvider,
			'modelTitle' => $this->modelTitle
        ]); */
    }

    public function actionView($id)
    {
        return $this->render('/catalog/view', [
            'model' => $this->findModel($id),
			'modelTitle' => $this->modelTitle
        ]);
    }

    public function actionCreate()
    {
        $model = new $this->modelName;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
			return $this->redirect(['index']);
        } else {
            return $this->render('/catalog/create', [
                'model' => $model,
				'modelTitle' => $this->modelTitle
            ]);
        }
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('/catalog/update', [
                'model' => $model,
				'modelTitle' => $this->modelTitle
            ]);
        }
    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = call_user_func([$this->modelName , 'findOne'],  $id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
