<?php

namespace app\models;

use Yii;

class Custum extends \yii\base\Model
{
    public $custum_num;
    public $custum_date;
    public $vins;

    public function rules()
    {
        return [
            [['custum_date', 'custum_num', 'vins'], 'required'],
            [['custum_date'], 'safe'],
            [['custum_num', 'vins'], 'string']
        ];
    }

    public function attributeLabels()
    {
        return [
            'custum_date' => Yii::t('app', 'Custum Date'),
            'custum_num' => Yii::t('app', 'Custum custum_num'),
            'vins' => Yii::t('app', 'VIN'),
        ];
    }

}
