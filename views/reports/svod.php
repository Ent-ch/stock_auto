<?php

use yii\helpers\Html;
use yii\grid\GridView;

//use kartik\export\ExportMenu;


$this->title = $reportTitle;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?php 
    echo GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'model',
//            'name',
			[
//				'attribute' => 'cnt',
                'content' => function ($data) {
                    return '<pre>' .  print_r($data, true) . '</pre>';
                },
				'label' => Yii::t('app', 'Cnt'),
			],
        ],
	]);
    ?>
    
</div>
