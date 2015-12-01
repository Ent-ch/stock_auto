<?php

namespace app\models\cats;

use Yii;

class Kved extends \app\models\Catalog 
{
    public static function tableName()
    {
        return 'cat_ukved';
    }

	public function attributeLabels()
    {
		return self::SetArrayAtrs(['name' => 'Kved']);
    }

}

