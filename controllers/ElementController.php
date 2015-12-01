<?php

namespace app\controllers;

use Yii;
use app\models\Catalog;
use app\models\Element;
use app\models\ElementSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ElementController implements the CRUD actions for Element model.
 */
class ElementController extends CatalogController
{

	public $modelName = 'app\models\Element';
	public $modelTitle = 'Salon colors';
	
	/**
     * Lists all Element models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ElementSearch();
        $dataProvider = $searchModel->search($this->modelName, Yii::$app->request->queryParams);

        return $this->render('/element/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
			'modelTitle' => $this->modelTitle,
        ]);
    }

    /**
     * Displays a single Element model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('/element/view', [
            'model' => $this->findModel($id),
			'modelTitle' => $this->modelTitle,
        ]);
    }

    /**
     * Creates a new Element model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new $this->modelName();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/element/view', 'id' => $model->id]);
        } else {
            return $this->render('/element/create', [
                'model' => $model,
				'modelTitle' => $this->modelTitle,
            ]);
        }
    }

    /**
     * Updates an existing Element model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('/element/update', [
                'model' => $model,
				'modelTitle' => $this->modelTitle,
            ]);
        }
    }

}
