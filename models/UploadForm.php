<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\web\UploadedFile;
use mdm\upload\FileModel;

/**
 * UploadForm is the model behind the upload form.
 */
class UploadForm extends Model
{
    /**
     * @var UploadedFile file attribute
     */
    public $file;
    public $file_id;

	public function behaviors()
	{
		return [
			'upload' => 
			[
				'class' => 'mdm\upload\UploadBehavior',
				'attribute' => 'file', // required, use to receive input file
				'savedAttribute' => 'file_id', // optional, use to link model with saved file.
				'uploadPath' => '@webroot/uploads', // saved directory. default to '@runtime/upload'
				'directoryLevel' => 0,
//				'autoSave' => true, // when true then uploaded file will be save before ActiveRecord::save()
//				'autoDelete' => true, // when true then uploaded file will deleted before ActiveRecord::delete()
			],
		];
	}	
    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['file'], 'file', 'extensions' => 'txt' ],
            [['file_id'], 'integer'],
        ];
    }
	
    public function attributeLabels()
    {
        return [
            'file' => Yii::t('app', 'file'),
        ];
    }

	public function getFileName()
	{
		$filename = FileModel::findOne($this->file_id)->filename;
		return $filename;
	}
}
