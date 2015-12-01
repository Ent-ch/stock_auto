<?php

namespace app\models\cats;

use Yii;

class Stock extends \app\models\Catalog 
{
    public static function tableName()
    {
        return 'cat_stocks';
    }

}

