<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use app\models as Mod;
use kartik\select2\Select2;
use yii\widgets\Menu;
use yii\bootstrap\Tabs;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CarSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Menu::widget([
            'options' => [
                'class' => 'nav nav-tabs'
            ],
            'items' => [
                ['label' => Yii::t('app', 'Cars on road'),  'url' => ['/status/index']],
                ['label' => Yii::t('app', 'Cars on custum'),  'url' => ['/status/custum']],
                ['label' => Yii::t('app', 'Cars on distr'), 'url' => ['/status/distr'],],
            ]
        ]) ?>	

<div class="car-index">

    <h1><?php //= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>


    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
//            'car.model.code',
			[
				'attribute' => 'model_id',
				'value' => 'car.model.full_name',
				'label' => Yii::t('app', 'Model ID'),
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
				'value' => 'car.color.name',
				'label' => Yii::t('app', 'Color ID'),
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
			[
				'attribute' => 'color_sal_id',
				'value' => 'car.colorsal.name',
				'label' => Yii::t('app', 'Color Sal ID'),
				'filter' => ArrayHelper::map(Mod\cats\ColorSalon::findAll(Mod\Car::getDiscArray('color_sal_id')), 'id', 'name'),
			],

			[
				'attribute' => 'diller.name',
				'label' => Yii::t('app', 'Diller'),
			],
            'custum_date:date',
			
			[ 
				'attribute' => 'vin',
				'value' => 'car.vin',
			],
			[
				'attribute' => 'enj_num',
				'value' => 'car.enj_num',
				'label' => Yii::t('app', 'Enj Num'),
			],
			[
				'attribute' => 'stock.name',
//				'value' => 'car.enj_num',
				'label' => Yii::t('app', 'Stock'),
			],
			[
				'attribute' => 'plant.date_shipping',
				'label' => Yii::t('app', 'Shiping date'),
			],
//            'stock.name',

        ],
    ]); ?>

</div>
