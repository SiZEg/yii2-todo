<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\RegistrationForm */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = Yii::t('app', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

	<?php
	$form = ActiveForm::begin([
			'id' => 'registration-form',
			'options' => ['class' => 'form-horizontal'],
			'fieldConfig' => [
				'template' => "{label}\n<div class=\"col-lg-4\">{input}</div>\n<div class=\"col-lg-6\">{error}</div>",
				'labelOptions' => ['class' => 'col-lg-2 control-label'],
			],
	]);
	?>

	<?= $form->field($model, 'email') ?>

	<?= $form->field($model, 'password')->passwordInput() ?>
	
	<?= $form->field($model, 'password_conf')->passwordInput() ?>

	<?= $form->field($model, 'phone') ?>
	
	<?= $form->field($model, 'name') ?>
	
	<div class="form-group">
		<div class="col-lg-offset-2 col-lg-11">
			<?= Html::submitButton(Yii::t('app', 'Sign Up'), ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
		</div>
	</div>

	<?php ActiveForm::end(); ?>
</div>
