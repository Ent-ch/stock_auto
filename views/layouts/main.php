<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

use \kartik\alert\AlertBlock;
use \amnah\user;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
$this->title = 'Управление остатками';
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>
    <div class="wrap">
        <?php
            NavBar::begin([
                'brandLabel' => 'Управление остатками',
                'brandUrl' => Yii::$app->homeUrl,
                'options' => [
                    'class' => 'navbar-inverse navbar-fixed-top',
                ],
            ]);
			$items = [
              ['label' => 'Главная', 'url' => ['/site/index']],
//              ['label' => 'Обратная связь', 'url' => ['/site/contact']],
			  ];
			if (Yii::$app->user->isGuest) {
				$items[] = ['label' => 'Вход', 'url' => ['/user/login']];
			} else {
				
				$items[] = ['label' => 'Управление', 'url' => ['/status/index']];
				
				$items[] = ['label' => 'Загрузка данных',
							'items' => [
								['label' => 'Загрузка манифестов', 'url' => ['/data-import/upload-manifest']],
								['label' => 'Загрузка пакингов', 'url' => ['/data-import/upload-packing']],
								['label' => 'Пакетное присвоение', 'url' => ['/paket/index']],
								['label' => 'Пакетное перемещение', 'url' => ['/paket/stock']],
								['label' => 'Пакетное ведение деклараций', 'url' => ['/paket/custum']],
							]];

				$items[] = ['label' => 'Отчеты',
							'items' => [
//								['label' => 'Коды моделей', 'url' => ['/reports/index']],
								['label' => 'Поставки по датам', 'url' => ['/reports/postavki']],
							]];

				$items[] = ['label' => 'Справочники',
							'items' => [
								['label' => 'Заводы', 'url' => ['/catalog/index']],
								['label' => 'Корабли', 'url' => ['/cats/ship/index']],
								['label' => 'Кведы', 'url' => ['/cats/kved/index']],
								['label' => 'Цвета', 'url' => ['/cats/color/index']],
								['label' => 'Цвета салона', 'url' => ['/element/index']],
								['label' => 'Модели', 'url' => ['/catmodel/index']],
								['label' => 'Автомобили', 'url' => ['/car/index']],
								['label' => 'Склады', 'url' => ['/cats/stock/index']],
								['label' => 'Диллеры', 'url' => ['/cats/diller/index']],
							]];
                if (Yii::$app->user->identity->role_id === 1){
                    $items[] = ['label' => 'Администр.',
                                'items' => [
                                    ['label' => 'Пользователи', 'url' => ['/user/admin/index']],
                                    ['label' => 'Посещения', 'url' => ['/request-log']],
                                ]];
                }

				$items[] = ['label' => 'Выход (' . Yii::$app->user->identity->username . ')',
                            'url' => ['/user/logout'],
                            'linkOptions' => ['data-method' => 'post']];
			}
			
            echo Nav::widget([
                'options' => ['class' => 'navbar-nav navbar-right'],
                'items' => $items,
            ]);
			
            NavBar::end();
        ?>

        <div class="container">
            <?= Breadcrumbs::widget([
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
			<?php 
				echo AlertBlock::widget([
					'type' => AlertBlock::TYPE_ALERT,
					'useSessionFlash' => true,
					'delay' => 0
				]);
//            print_r(Yii::$app->user->identity->role_id);
			?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <div class="container">
            <p class="pull-left">&copy; Управление остатками <?= date('Y') ?></p>
            <p class="pull-right"><?= Yii::powered() ?></p>
        </div>
    </footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
