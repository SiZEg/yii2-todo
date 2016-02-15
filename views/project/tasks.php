<?php

/* @var $this yii\web\View */
/* @var $model models\Prohect */

use yii\helpers\Html;

$this->title = Yii::t('app', $model->title);
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="project-tasks">
	<h1><?= $this->title ?></h1>
	
	<div class="tasks">
		<ul class="tasks__list">
			
		</ul>
	</div>
</div>