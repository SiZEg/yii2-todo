<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Authenticate');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

	<?php
	$form = ActiveForm::begin([
			'id' => 'login-form',
			'options' => ['class' => 'form-horizontal'],
			'fieldConfig' => [
				'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
				'labelOptions' => ['class' => 'col-lg-1 control-label'],
			],
	]);
	?>

	<?= $form->field($model, 'email') ?>

	<?= $form->field($model, 'password')->passwordInput() ?>

	<?=
	$form->field($model, 'rememberMe')->checkbox([
		'template' => "<div class=\"col-lg-offset-1 col-lg-3\">{input} {label}</div>\n<div class=\"col-lg-8\">{error}</div>",
	])
	?>

	<div class="form-group">
		<div class="col-lg-offset-1 col-lg-11">
			<?= Html::submitButton(Yii::t('app', 'Sign In'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
			<?= Html::button(Yii::t('app', 'Sign Up'), ['type' => 'button', 'class' => 'btn btn-primary', 'onclick' => new \yii\web\JsExpression('(function(){ location.href=\''.Yii::$app->urlManager->createUrl(['/site/registration']).'\'; })();')]) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>
</div>
