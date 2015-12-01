<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<h1><?= $title?></h1>
<div class="row">

<?php
$form = ActiveForm::begin([
    'id' => 'vins-form',
    'options' => ['class' => ''],
]) ?>
    
	<div class="col-lg-1"></div>
	<div class="col-lg-3">
		<?= $form->field($model, 'vins')->textarea(['rows' => 30]) ?>
	</div>
	<div class="col-lg-3">

		<?= $form->field($model, 'diller')->label($selLabel)->dropDownList($list, ['prompt' => $prompt])
		?>
		
		<div class="form-group">
			<div class="col-lg-offset-1 col-lg-11">
				<?= Html::submitButton(Yii::t('app', 'Apply'), ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
<?php ActiveForm::end() ?>
	
</div>