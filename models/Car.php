<?php

namespace app\models;

use Yii;
/**
 * This is the model class for table "cat_cars".
 *
 * @property integer $id
 * @property integer $model_id
 * @property integer $color_id
 * @property integer $color_sal_id
 * @property string $vin
 * @property string $enj_num
 *
 * @property CatModels $model
 * @property CatColors $color
 * @property CatSalonsColor $colorSal
 */
class Car extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_cars';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model_id', 'color_id', 'color_sal_id', 'vin', 'enj_num'], 'required'],
            [['model_id', 'color_id', 'color_sal_id'], 'integer'],
            ['vin', 'string', 'max' => 17],
            ['enj_num', 'string', 'max' => 12],
			['vin', 'unique'],
			['vin', 'match', 'pattern' => Yii::$app->params['vinRegExp'], 'message' => Yii::t('app', 'Wrong VIN')]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'model_id' => Yii::t('app', 'Model ID'),
            'color_id' => Yii::t('app', 'Color ID'),
            'color_sal_id' => Yii::t('app', 'Color Sal ID'),
            'vin' => Yii::t('app', 'Vin'),
            'enj_num' => Yii::t('app', 'Enj Num'),
        ];
    }

    public static function getDiscArray($col_name)
    {
		$query = Car::find();
		$result = [];
		foreach($query->select($col_name)->distinct()->asArray()->all() as $row){
			$result[] = $row[$col_name];
		}
		return $result;
    }

	/**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(CatModel::className(), ['id' => 'model_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(cats\Color::className(), ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColorsal()
    {
        return $this->hasOne(cats\ColorSalon::className(), ['id' => 'color_sal_id']);
    }
}
