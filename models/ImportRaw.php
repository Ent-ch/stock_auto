<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dat_imports_raw".
 *
 * @property integer $id
 * @property string $type
 * @property string $vin
 * @property string $data
 * @property integer $file_id
 *
 * @property UploadedFile $file
 */
class ImportRaw extends BaseModel
{
	private static $packing = ['model' => 105, 'color' => 94, 'salon' => 97, 'enj' => 74,
				 'prod_ord' => 10, 'carrier' => 34, 'key_code' => 89, 
				 'date_shipping' => 26, 'ship_code' => 44, 'num_invoice' => 10, 
				];
	private static $manifest = ['model' => 69, 'color' => 86, 'salon' => 89, 'enj' => 144,
				 'prod_ord' => 0, 'carrier' => 45, 'key_code' => 159, 
				 'date_shipping' => 28, 'ship_code' => 42, 'num_invoice' => 53, 
				];

	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dat_imports_raw';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'vin', 'data', 'file_id'], 'required'],
            [['type', 'data'], 'string'],
            [['file_id', 'imported'], 'integer'],
            ['vin', 'string', 'max' => 17],
			['vin', 'match', 'pattern' => Yii::$app->params['vinRegExp'], 'message' => Yii::t('app', 'Wrong VIN')],
            ['vin', 'unique'],
			
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'type' => Yii::t('app', 'Type'),
            'vin' => Yii::t('app', 'Vin'),
            'data' => Yii::t('app', 'Data'),
            'file_id' => Yii::t('app', 'File ID'),
        ];
    }

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getFile()
    {
        return $this->hasOne(UploadedFile::className(), ['id' => 'file_id']);
    }
	
	
	private static function getPosArray($type)
	{
		return self::$$type;
	}
		
	public static function importData()
	{
		$arr_error = [];
		$timeimport = time();
		
		foreach (ImportRaw::find()->where(['imported' => null])->each() as $rawData) {
			$data = $rawData->data;
			$arrayPos = self::getPosArray($rawData->type);
//			$arrayPos = $$arrayPos;
			$codmodel = str_ireplace(' ', '', substr($data, $arrayPos['model'], 17));
			$codColor = trim(substr($data, $arrayPos['color'], 3));
			$codSalon = trim(substr($data, $arrayPos['salon'], 3));
			$codEnj = trim(substr($data, $arrayPos['enj'], 12));

			$prodOrd = trim(substr($data, $arrayPos['prod_ord'], 5));
			$carrier = trim(substr($data, $arrayPos['carrier'], 8));
			$keyCode = trim(substr($data, $arrayPos['key_code'], 5));
			$dateShipping = trim(substr($data, $arrayPos['date_shipping'], 8));
			$shipCode = trim(substr($data, $arrayPos['ship_code'], 3));
			$numInvoice = trim(substr($data, $arrayPos['num_invoice'], 16));
			
			$car = new Car;
			$car->model_id = CatModel::findOne(['code' => $codmodel])->id;
			$car->color_id = cats\Color::findOne(['code' => $codColor])->id;
			$car->color_sal_id = cats\ColorSalon::find()->where(['name' => $codSalon])->one()->id;
			$car->vin = $rawData->vin;
			$car->enj_num = $codEnj;
			
			if ($car->validate()){
				$car->save();
			} else {
				$arr_error[] = $car->getErrorsAsString();
//				continue;
			}
			if ($sCarmod = Car::findOne(['vin' => $rawData->vin])){
				$impData = new ImportPlant;
				$impData->production_ord = $prodOrd;
				$impData->carrier = $carrier;
				$impData->key_code = $keyCode;
				$impData->car_id = $sCarmod->id;
				$impData->date_shipping = $dateShipping;
				$impData->ship_code = $shipCode;
				$impData->num_invoice = $numInvoice;

				if ($impData->validate()){
					$impData->save();

					$car_status = new CarStatus;
					$car_status->car_id = $sCarmod->id;
					$car_status->status = 'way';
					$car_status->imp_data_id = $impData->id;
					if ($car_status->validate()){
						$car_status->save();
					} else {
						$arr_error[] =  $car_status->getErrorsAsString();
					}
				} else {
					$arr_error[] =  $impData->getErrorsAsString();
//					continue;
				}
			}
			$rawData->imported = $timeimport;
			$rawData->save();
			
			
		}
		return $arr_error;
	}
}
