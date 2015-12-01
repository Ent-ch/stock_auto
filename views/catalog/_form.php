<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Catalog */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="catalog-form">
    <?php $form = ActiveForm::begin(); ?>
	<div class="row">

		<div class="col-md-2">
		<?= $form->field($model, 'code')->textInput(['maxlength' => 40]) ?>
		</div>

		<div class="col-md-10">
		<?= $form->field($model, 'name')->textInput(['maxlength' => 100]) ?>
		</div>
	
	</div>
	
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
	
</div>
