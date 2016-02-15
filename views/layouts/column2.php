<?php
use app\widgets\SidebarProjectFormWidget;
use app\widgets\SidebarProjectListWidget;

$this->registerCss("
	.w-spf-wrap,
	.projects-list {
		margin-bottom: 10px;
	}
");
?>

<?php $this->beginContent('@app/views/layouts/main.php'); ?>
<div class="container">
	<div class="row row-offcanvas row-offcanvas-right">
		<div class="col-xs-12 col-sm-9" id="pjax-container">
			<?= $content ?>
		</div><!--/.col-xs-12.col-sm-9-->
		<div class="col-xs-6 col-sm-3 sidebar-offcanvas" id="sidebar">
			<?php if (!Yii::$app->user->isGuest): ?>
				<div class="w-project-wrap">
					<?= SidebarProjectListWidget::widget([
						'projectCreateSelector' => '#project-simple-form'
					]) ?>
				</div>

				<div class="w-spf-wrap">
					<?= SidebarProjectFormWidget::widget() ?>
				</div>
			<?php endif; ?>
		</div><!--/.sidebar-offcanvas-->
	</div><!--/row-->
</div><!--/.container-->
<?php $this->endContent(); ?>
