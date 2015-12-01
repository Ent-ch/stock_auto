<?php

namespace app\models;

use Yii;

class BaseModel extends \yii\db\ActiveRecord
{

	public function getErrorsAsString(){
		return implode("; ",array_map(function($a) {return implode(" = ",$a);}, $this->geterrors()));
	}

}
