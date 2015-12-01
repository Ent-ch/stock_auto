<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use kartik\file\FileInput;


$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>

<h2><?= $this->title ?></h2>

<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>


    <div class="form-group">

	<?=  $form->field($model, 'file')->widget(FileInput::classname(), ['options' => ['multiple' => false], 'pluginOptions' => [
        'showPreview' => false,
        'showCaption' => true,
        'showRemove' => true,
        'showUpload' => false,
    	]]) ?>

            <?= Html::submitButton(Yii::t('app', 'Load'), ['class' => 'btn btn-primary']) ?>
    </div>


<?php ActiveForm::end() ?>