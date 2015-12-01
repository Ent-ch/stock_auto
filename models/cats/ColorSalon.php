<?php

namespace app\models\cats;

use Yii;

class ColorSalon extends \app\models\Element 
{
    public static function tableName()
    {
        return 'cat_salons_color';
    }

    public function attributeLabels()
    {
        return [
            'name' => Yii::t('app', 'Salon color'),
        ];
    }
	
}

