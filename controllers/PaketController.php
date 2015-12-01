<?php

namespace app\controllers;

use Yii;
use yii\base\DynamicModel;
use yii\helpers\ArrayHelper;
use app\models as Mod;

class PaketController extends BaseController
{
	
    public function actionIndex()
    {
		$debug = '';
		$model = new DynamicModel([
			'vins', 'diller'
			]);

		$model->addRule('vins', 'string')
				->addRule('diller', 'integer')
				->addRule(['diller', 'vins'], 'required');
		
		
		$list = ArrayHelper::map(Mod\cats\Diller::find()->all(), 'id', 'name');
		$prompt = Yii::t('app', 'Select diller');
		
		$arrError = [];
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//			Yii::$app->session->setFlash('success', Yii::t('app', 'Done'));
//			$debug = print_r(Yii::$app->request->post('DynamicModel'), true);
			$arrvin = explode("\n", $model->vins);
			foreach ($arrvin as $vin) {
				if ($car = Mod\Car::findOne(['vin' => trim($vin)])){
					$status = Mod\CarStatus::findOne(['car_id' => $car->id]);
					$status->diller_id = $model->diller;
					$status->save();
				} else {
					$arrError[]	 = $vin . ' не найден VIN';
				}
			}
			$debug = implode('<br>', $arrError);
			
			return $this->render('finish', ['debug' => $debug]);
		}
		$arrVars = ['model' => $model, 'list' => $list, 'prompt' => $prompt, 'selLabel' => 'Диллер', 'title' => 'Пакетное присвоение' ];
		return $this->render('index', $arrVars);
	}

	public function actionStock()
    {
		$debug = '';
		$model = new DynamicModel([
			'vins', 'diller'
			]);

		$model->addRule('vins', 'string')
				->addRule('diller', 'integer')
				->addRule(['diller', 'vins'], 'required');
		
		
		$list = ArrayHelper::map(Mod\cats\Stock::find()->all(), 'id', 'name');
		$prompt = Yii::t('app', 'Select stock');
		
		$arrError = [];
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			$arrvin = explode("\n", $model->vins);
			foreach ($arrvin as $vin) {
				if ($car = Mod\Car::findOne(['vin' => trim($vin)])){
					$status = Mod\CarStatus::findOne(['car_id' => $car->id]);
					$status->stock_id = $model->diller;
					$status->save();
				} else {
					$arrError[]	 = $vin . ' не найден VIN';
				}
			}
//			$debug = print_r($arrError, true);
			$debug = implode('<br>', $arrError);
			return $this->render('finish', ['debug' => $debug]);
		}
		$arrVars = ['model' => $model, 'list' => $list, 'prompt' => $prompt, 'selLabel' => 'Склад', 'title' => 'Пакетное перемещение' ];
		return $this->render('index', $arrVars);
	}

	public function actionCustum()
    {
		$debug = '';
		$model = new Mod\Custum;
		
		$prompt = Yii::t('app', 'Select stock');
		
		$arrError = [];
		if ($model->load(Yii::$app->request->post())) {
			if (!$model->validate()){
				$debug = print_r($model->geterrors(), true);
				return $this->render('finish', ['debug' => $debug]);
			}
			$arrvin = explode("\n", $model->vins);
			foreach ($arrvin as $vin) {
				if ($car = Mod\Car::findOne(['vin' => trim($vin)])){
					$status = Mod\CarStatus::findOne(['car_id' => $car->id]);
					$status->custum_date = $model->custum_date;
					$status->custum_num = $model->custum_num;
					$status->save();
				} else {
					$arrError[]	 = $vin . ' не найден VIN';
				}
			}
			$debug = implode('<br>', $arrError);
			return $this->render('finish', ['debug' => $debug]);
		}
		
		$arrVars = ['model' => $model, 'prompt' => $prompt, 'selLabel' => 'Склад', 'title' => 'Пакетное ведение деклараций' ];
		return $this->render('custum', $arrVars);
	}

}
