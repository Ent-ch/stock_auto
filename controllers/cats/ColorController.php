<?php

namespace app\controllers\cats;

use Yii;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class ColorController extends \app\controllers\CatalogController
{
	public $modelName = 'app\models\cats\Color';
	public $modelTitle = 'Color';
}
