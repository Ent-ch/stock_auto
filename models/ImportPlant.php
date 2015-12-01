<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "dat_imports_plant".
 *
 * @property integer $id
 * @property string $production_ord
 * @property string $carrier
 * @property string $key_code
 * @property integer $car_id
 * @property string $date_shipping
 * @property string $ship_code
 * @property string $num_invoice
 *
 * @property CatCars $car
 */
class ImportPlant extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'dat_imports_plant';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['production_ord', 'carrier', 'key_code', 'car_id'], 'required'],
            [['car_id'], 'integer'],
            [['production_ord', 'key_code'], 'string', 'max' => 5],
            [['carrier'], 'string', 'max' => 18],
            [['date_shipping'], 'string', 'max' => 8],
            [['ship_code'], 'string', 'max' => 3],
            [['num_invoice'], 'string', 'max' => 16],
            [['car_id'], 'unique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'production_ord' => Yii::t('app', 'Production Ord'),
            'carrier' => Yii::t('app', 'Carrier'),
            'key_code' => Yii::t('app', 'Key Code'),
            'car_id' => Yii::t('app', 'Car ID'),
            'date_shipping' => Yii::t('app', 'Date Shipping'),
            'ship_code' => Yii::t('app', 'Ship Code'),
            'num_invoice' => Yii::t('app', 'Num Invoice'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCar()
    {
        return $this->hasOne(CatCars::className(), ['id' => 'car_id']);
    }
}
