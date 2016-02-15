<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\Project;

/**
 * ProjectSimpleForm is the model for fast create project form
 */
class ProjectSimpleForm extends Model
{

	public $title;
	
	public $model;

	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			['title', 'required', 'message' => 'Укажите название проекта'],
			['title', 'string', 'max' => 255],
		];
	}
	
	public function attributeLabels()
	{
		return [
			'title' => 'Название проекта'
		];
	}

	/**
	 * Form saving
	 * 
	 * @return boolean
	 */
	public function save()
	{
		if ($this->validate()) {
			$this->model = new Project;
			$this->model->title = $this->title;
			$this->model->is_active = 1;
			$this->model->is_deleted = 0;
			$this->model->sort = Project::getActiveMaxSort() + 1;
			return $this->model->save(false);
		}

		return false;
	}

}
