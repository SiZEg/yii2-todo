<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
	<meta charset="<?= Yii::$app->charset ?>">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
	<meta name="description" content="">
	<meta name="author" content="">
	<!--<link rel="icon" href="../../favicon.ico">-->
	<?= Html::csrfMetaTags() ?>

	<title><?= (!empty($this->title) ? Html::encode($this->title).' — ' : '').Yii::t('app', Yii::$app->name) ?></title>

	<?php $this->head() ?>
</head>

<body>
	<?php $this->beginBody() ?>
    <?php
    NavBar::begin([
        'brandLabel' => Yii::t('app', Yii::$app->name),
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
	?>
	
	<!-- @todo Fixed collapsing search form -->
	<form class="navbar-form navbar-left" role="search">
	<div class="form-group">
		<input type="text" class="form-control" placeholder="<?= Yii::t('app', 'Searching tasks') ?>">
	</div>
	<button type="submit" class="btn btn-default"><?= Yii::t('app', 'Search') ?></button>
	</form>
	
	<?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            ['label' => Yii::t('app', 'Home'), 'url' => ['/site/index']],
            ['label' => Yii::t('app', 'About'), 'url' => ['/site/about']],
            ['label' => Yii::t('app', 'Contact'), 'url' => ['/site/contact']],
            Yii::$app->user->isGuest ?
                ['label' => Yii::t('app', 'Sign In'), 'url' => ['/site/login']] :
                ['label' => Yii::t('app', 'Logout'), 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']],
        ],
    ]);
    NavBar::end();
    ?>
	
	<?= $content ?>

	<footer>
		<div class="container">
			<p class="pull-left">&copy; <?= Yii::t('app', Yii::$app->name) ?> 2016</p>

			<p class="pull-right"><?= Yii::powered() ?></p>
		</div>
	</footer>

	<!-- Bootstrap core JavaScript
	================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
	<!--<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>-->
	<!--<script src="../../dist/js/bootstrap.min.js"></script>-->
	<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
	<!--<script src="../../assets/js/ie10-viewport-bug-workaround.js"></script>-->
	<!--<script src="offcanvas.js"></script>-->
	
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>