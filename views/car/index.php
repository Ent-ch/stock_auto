<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models as Mod;
use kartik\select2\Select2;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Cars');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="car-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Car'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'model.code',
			[
				'attribute' => 'model_id',
				'value' => 'model.full_name',
				'filter' => Select2::widget([
                            'model' => $searchModel, 
                            'attribute' => 'model_id',
							'data' => ArrayHelper::map(Mod\CatModel::findAll(Mod\Car::getDiscArray('model_id')), 'id', 'full_name'),
						    'options' => ['placeholder' => Yii::t('app', 'Select a model')],
							'pluginOptions' => [
								'allowClear' => true
							],
						]),
			],
			[
				'attribute' => 'color_id',
				'value' => 'color.name',
				'filter' => Select2::widget([
                            'model' => $searchModel, 
                            'attribute' => 'color_id',
							'data' => ArrayHelper::map(Mod\cats\Color::findAll(Mod\Car::getDiscArray('color_id')), 'id', 'name'),
						    'options' => ['placeholder' => Yii::t('app', 'Select a color')],
							'pluginOptions' => [
								'allowClear' => true
							],
						]),
			],
//            'model.full_name',
//            'color.name',
			[
				'attribute' => 'color_sal_id',
				'value' => 'colorsal.name',
				'filter' => ArrayHelper::map(Mod\cats\ColorSalon::findAll(Mod\Car::getDiscArray('color_sal_id')), 'id', 'name'),
			],
            'vin',
            'enj_num',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
