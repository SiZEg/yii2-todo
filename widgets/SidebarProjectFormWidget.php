<?php

namespace app\widgets;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

//use app\models\Post;
//use yii\helpers\Html;
class SidebarProjectFormWidget extends \yii\base\Widget
{

	public function run()
	{
		parent::run();
		
		$model = new \app\models\ProjectSimpleForm;
		
		$form = ActiveForm::begin([
			'id' => 'project-simple-form',
			'action' => ['/project/simplecreate'],
			'layout' => 'inline',
//			'enableClientValidation' => false,
			'validateOnChange' => false,
			'validateOnBlur' => false,
		]);
		
		echo $form->field($model, 'title')->textInput(['maxlength' => 255, 'class' => 'form-control input-sm'])->label(false);
		
		echo '<div class="form-group">'
				.Html::submitButton(Yii::t('app', 'Create'), ['class' => 'btn btn-sm btn-success', 'style' => 'margin: 5px 5px 5px 0;'])
				.Html::resetButton(Yii::t('app', 'Cancel'), ['class' => 'btn btn-xs', 'style' => 'margin: 5px;'])
			.'</div>';

		ActiveForm::end();
		
		$this->registerJs();
	}
	
	protected function registerJs()
	{
		$view = Yii::$app->getView();
		$view->registerJs("
			$('#project-simple-form').on('beforeSubmit', function(e){
				jQuery.ajax({
					url: $(this).attr('action'),
					type: 'POST',
					dataType: 'json',
					data: $(this).serialize()
				}).done(function(data, textStatus, jqXHR){
					console.log('Form data:', data);
					if (data.success) {
						$('#project-simple-form').yiiActiveForm('resetForm');
						$('#project-simple-form')[0].reset();
						$('#project-simple-form').trigger('project:created', [data.project]);
					} else {
						if (data.errors) {
							$('#project-simple-form').yiiActiveForm('updateMessages', data.errors);
						} else {
							// Temporarry create console logs
							console.log('Error on #simple-project-form submit.');
						}
					}
				}).fail(function(jqXHR, textStatus, errorThrown){
					// Temporarry create console logs
					console.log('Fail on #simple-project-form submit.');
				});

				return false;
			});
		");
	}

//	public function renderPosts($posts)
//	{
//		$items = [];
//		foreach ($posts as $post) {
//			$items[] = $this->renderPost($post);
//		}
//		return implode("\n", $items);
//	}
//
//	public function renderPost($post)
//	{
//		return '<li>' . Html::a(Html::encode($post->title), ['post/view', 'id' => $post->id]) . '</li>';
//	}

}
