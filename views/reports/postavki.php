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
//        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
//            'model_code',
//            'name',
//			[
//				'attribute' => 'cnt',
//				'label' => Yii::t('app', 'Cnt'),
//			],
//        ],
	]);
    ?>
    
    <?php
//echo \kartik\grid\GridView::widget([
//    'dataProvider' => $dataProvider,
//]);    
    ?>
<?php
//echo ExportMenu::widget([
//    'dataProvider' => $dataProvider,
////    'columns' => $gridColumns
//]);

    ?>

</div>
