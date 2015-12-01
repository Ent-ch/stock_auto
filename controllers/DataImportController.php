<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\UploadForm;
use app\models\ImportRaw;
use app\models as Mod;
use yii\web\UploadedFile;

use yii\base\DynamicModel;


class DataImportController extends BaseController
{
	private function doImport($model, $type = 'manifest')
	{
		$debug = '';

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->saveUploadedFile() !== false) {
//				Yii::$app->session->setFlash('success', 'Upload Sukses');
				$arr_rows = explode("\r\n", file_get_contents($model->getFileName()));
				$arr_error = $this->importData($arr_rows, $type, $model->file_id);				
				$debug = print_r($arr_error, true);
				if ($debug) {
					Yii::$app->session->setFlash('error', $debug);
				}
				return ['debug' => $debug , 'message' => Yii::t('app', 'Load complite')];
			}
		}
		
		return false;
	}
	
	private function importData($arr_rows, $type_file, $file_id)
	{
		$arr_error = [];
		switch ($type_file){
			case 'packing':
				$begpos = 57;
				break;
			default:
				$begpos = 127;
		}

		foreach ($arr_rows as $row){
			if (strlen(trim($row)) === 0){
				continue;
			}
			$vin = substr($row, $begpos, 17);
			$extData = new ImportRaw;
			$extData->type = $type_file;
			$extData->vin = $vin;
			$extData->data = $row;
			$extData->file_id = $file_id;
			if ($extData->validate()){
				$extData->save();
			} else {
				$arr_error[] = (count($arr_error) + 1) . '. ' . $vin . ' - ' . $extData->getErrorsAsString();
			}
		}
		$err = implode("\n", $arr_error);
		return $err;
	}
		
    public function actionUploadManifest()
    {
        $model = new UploadForm();
		if (is_array($arrView = $this->doImport($model))) {
			return $this->actionImportAll();
			return $this->render('final', $arrView);
		}
		return $this->render('upload-file', ['model' => $model, 'title' => Yii::t('app', 'Load manifest') ]);
    }

    public function actionUploadPacking()
    {
        $model = new UploadForm();
		if (is_array($arrView = $this->doImport($model, 'packing'))) {
			return $this->render('final', $arrView);
		}
		return $this->render('upload-file', ['model' => $model, 'title' => Yii::t('app', 'Load packing') ]);
    }

    public function actionImportAll()
    {
		$arr_error = ImportRaw::importData();
		$mess = implode('<br>', $arr_error);
		$debug = print_r($mess, true);
		return $this->render('final', ['debug' => $debug , 'message' => 'Import complite']);
    }

	public function actionTempMess()
	{
		$debug = '';
//		$tvar = Mod\Car::getDiscArray('model_id');
//		$debug = print_r($tvar, true);
//		Yii::$app->session->setFlash('success', 'Upload Sukses!!!!!!!!!!!!');
		return $this->render('final', ['$popmessage' => 'Load complite', 'debug' => $debug]);
	}
	
	public function actionTempFile()
	{
		$model = new DynamicModel([
			'nama', 'file_id'
			]);

		// behavior untuk upload file
		$model->attachBehavior('upload', [
			'class' => 'mdm\upload\UploadBehavior',
			'attribute' => 'file',
			'savedAttribute' => 'file_id' // coresponding with $model->file_id
		]);

		// rule untuk model
		$model->addRule('nama', 'string')
			->addRule('file', 'file', ['extensions' => 'txt']);

		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->saveUploadedFile() !== false) {
				Yii::$app->session->setFlash('success', 'Upload Sukses');
			}
		}
		return $this->render('upload-manifest',['model' => $model]);
	}
	
}
