<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models as Mod;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $model app\models\Car */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="car-form">

    <?php $form = ActiveForm::begin(); ?>

    <?php //= $form->field($model, 'model_id')->textInput() ?>
    <?= $form->field($model, 'model_id')->widget(Select2::classname(), [
						'data' => ArrayHelper::map(Mod\CatModel::find()->all(), 'id', 'full_name'),
		])
	?>

    <?= $form->field($model, 'color_id')->widget(Select2::classname(), [
						'data' => ArrayHelper::map(Mod\Color::find()->all(), 'id', 'name'),
						'language' => Yii::$app->language,
/*						'options' => ['placeholder' => 'Select a state ...'],
						'pluginOptions' => [
							'allowClear' => true
						],
						*/
		])
	?>

	<?= $form->field($model, 'color_sal_id')->dropDownList(
			ArrayHelper::map(Mod\ColorSalon::find()->all(), 'id', 'name'),
			['prompt' => Yii::t('app', 'Select salon color')]
	) ?>

    <?= $form->field($model, 'vin')->textInput(['maxlength' => 17]) ?>

    <?= $form->field($model, 'enj_num')->textInput(['maxlength' => 12]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
