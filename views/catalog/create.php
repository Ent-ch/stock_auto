<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Catalog */

$this->title = Yii::t('app', "Create $modelTitle");
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', $modelTitle), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="catalog-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
