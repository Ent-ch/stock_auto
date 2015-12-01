<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "models".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 */
class Catalog extends BaseModel
{
    
	public static function SetArrayAtrs($atributes = null)
	{
		$arrayAtrs = [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Name'),
        ];
		if ($atributes) {
			foreach($atributes as $key => $val){
				$arrayAtrs[$key] = Yii::t('app', $val);
			}
		}
		return $arrayAtrs;
	}
	
	/**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_plants';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'string', 'max' => 40],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return self::SetArrayAtrs();
    }
	
}
