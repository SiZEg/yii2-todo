<?php

namespace app\widgets;

use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Project;

class SidebarProjectListWidget extends \yii\base\Widget
{

	public $projectCreateSelector;

	/**
	 * @var string BEM block css class
	 */
	public $bemBlockClass = 'sb-projects';

	/**
	 * @var array Projects list
	 */
	protected $projects = [];

	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$this->loadProjects();
	}

	/**
	 * @inheritdoc
	 */
	public function run()
	{
		parent::run();

		if (sizeof($this->projects)) {
			echo $this->renderList();

			$this->registerJs();
		}
	}

	/**
	 * @return string CSS class of the projects list
	 */
	protected function getBemListClass()
	{
		static $cssListClass;
		if ($cssListClass === null) {
			$cssListClass = $this->bemBlockClass . '__list';
		}
		return $cssListClass;
	}

	/**
	 * @return string CSS class of the projects list item
	 */
	protected function getBemItemClass()
	{
		static $cssItemClass;
		if ($cssItemClass === null) {
			$cssItemClass = $this->bemBlockClass . '__item';
		}
		return $cssItemClass;
	}

	/**
	 * @return string CSS class of the projects list item
	 */
	protected function getBemLinkClass()
	{
		static $cssLinkClass;
		if ($cssLinkClass === null) {
			$cssLinkClass = $this->bemBlockClass . '__link';
		}
		return $cssLinkClass;
	}

	/**
	 * Register JS
	 */
	protected function registerJs()
	{
		$view = Yii::$app->getView();
		$view->registerJs("
			$('" . $this->projectCreateSelector . "').on('project:created', function(e, project){
				//console.log('project:created:event', e);
				//console.log('project:created:project', project);
				$('#" . $this->getId() . " ul." . $this->getBemListClass() . "')
					.append('<li class=\"" . $this->getBemItemClass() . "\"><a href=\"#\" class=\"" . $this->getBemLinkClass() . "\" data-id=\"' + project.id + '\">' + project.title + '</a></li>');
			});
			
			$('#".$this->getId()."').on('click', '.".$this->getBemLinkClass()."', function(){
				window.location.href = '".Url::to(['/project/tasks'])."&id=' + $(this).data('id');
			});
		");
	}

	public function loadProjects()
	{
		$this->projects = Project::find()
			->active()
			->sortAsc()
			->userAll(Yii::$app->user->id);
	}

	/**
	 * Render list
	 */
	public function renderList()
	{
		echo '
			<div id="' . $this->getId() . '" class="' . $this->bemBlockClass . ' list-group">
				<ul class="' . $this->getBemListClass() . '">
					' . $this->renderItems($this->projects) . '
				</ul>
			</div><!-- .projects-list .list-group -->
		';
	}

	/**
	 * Render list items
	 * 
	 * @param array $items Models list
	 * @return string
	 */
	public function renderItems($items)
	{
		$content = '';
		$i = 0;
		foreach ($items as $k => $model) {
			$content .= $this->renderItem($model, $k, $i);
			$i++;
		}

		return $content;
	}

	/**
	 * Render list item
	 * 
	 * @param type $model The data model
	 * @param type $key Key from array of models
	 * @param type $index The zero-based index of the data model among the model array
	 * @return string
	 */
	public function renderItem($model, $key, $index)
	{
		return Html::tag('li', $this->renderItemContent($model, $key, $index), ['class' => $this->getBemItemClass()]);
	}

	/**
	 * Render item content
	 * 
	 * @param type $model The data model
	 * @param type $key Key from array of models
	 * @param type $index The zero-based index of the data model among the model array
	 * @return string
	 */
	public function renderItemContent($model, $key, $index)
	{
		return '<a href="#" class="' . $this->getBemLinkClass() . '" data-id="'.$model->id.'">' . $model->title . '</a>';
	}

}
