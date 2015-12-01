<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dat_cars_status".
 *
 * @property integer $id
 * @property integer $car_id
 * @property string $status
 * @property integer $imp_data_id
 * @property integer $diller_id
 * @property integer $stock_id
 * @property integer $custum_id
 *
 * @property CatStocks $stock
 * @property DatCustums $custum
 * @property CatCars $car
 * @property DatImportsPlant $impData
 */
class CarStatus extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dat_cars_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['car_id', 'status', 'imp_data_id'], 'required'],
            [['car_id', 'imp_data_id', 'diller_id', 'stock_id'], 'integer'],
            [['status'], 'string'],
			[['car_id'], 'unique'],
			[['custum_date'], 'safe'],
			[['custum_num'], 'string', 'max' => 200],
		];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'car_id' => Yii::t('app', 'Car ID'),
            'status' => Yii::t('app', 'Status'),
            'imp_data_id' => Yii::t('app', 'Imp Data ID'),
            'diller_id' => Yii::t('app', 'Diller ID'),
            'stock_id' => Yii::t('app', 'Stock ID'),
           	'custum_date' => Yii::t('app', 'Custum Date'),
           	'custum_num' => Yii::t('app', 'Custum Num'),        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStock()
    {
        return $this->hasOne(cats\Stock::className(), ['id' => 'stock_id']);
    }

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getDiller()
    {
        return $this->hasOne(cats\Diller::className(), ['id' => 'diller_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlant()
    {
        return $this->hasOne(ImportPlant::className(), ['id' => 'imp_data_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(Car::className(), ['id' => 'car_id']);
    }
}
