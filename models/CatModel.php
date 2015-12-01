<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_models".
 *
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $full_name
 *
 * @property WrkCars[] $wrkCars
 */
class CatModel extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_models';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['code'], 'required'],
            [['code'], 'string', 'max' => 40],
            [['name', 'full_name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'code' => Yii::t('app', 'Code'),
            'name' => Yii::t('app', 'Model name'),
            'full_name' => Yii::t('app', 'Model full name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getWrkCars()
    {
        return $this->hasMany(WrkCars::className(), ['model_id' => 'id']);
    }
}
