<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\CatalogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', $modelTitle);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create Catalog'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            [
                'attribute' => 'code',
//                'filter' => Html::activeInput('search', $searchModel, 'code', ['class' => 'form-control hasclear']), 
            ],
//            'code',
            'name',

            ['class' => 'yii\grid\ActionColumn', 'template' => '{update} {delete}',],
        ],

    ]); ?>

</div>
