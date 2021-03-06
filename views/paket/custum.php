<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datecontrol\DateControl;

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

    <?= $form->field($model, 'custum_date')->widget(DateControl::classname(), [
																			'type'=>DateControl::FORMAT_DATE,
//																			'convertFormat' => true,
																			'pluginOptions' => [
																				'autoclose' => true,
//																				'format' => 'y/MM/dd'
																			]]
																	  ) ?>
		
		<?= $form->field($model, 'custum_num')	?>
		
		<div class="form-group">
			<div class="col-lg-offset-1 col-lg-11">
				<?= Html::submitButton(Yii::t('app', 'Apply'), ['class' => 'btn btn-primary']) ?>
			</div>
		</div>
	</div>
<?php ActiveForm::end() ?>
	
</div>