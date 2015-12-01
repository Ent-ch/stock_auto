<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cat_salons_color".
 *
 * @property integer $id
 * @property string $name
 */
class Element extends BaseModel
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cat_salons_color';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', 'Name'),
        ];
    }
}
