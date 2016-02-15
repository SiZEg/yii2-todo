<?php

namespace app\controllers;

use Yii;
use yii\web\MethodNotAllowedHttpException;
use yii\web\Response;
use yii\widgets\ActiveForm;

use app\models\Project;
use app\models\ProjectSearch;
use yii\web\NotFoundHttpException;

/**
 * ProjectController implements the CRUD actions for Project model.
 */
class ProjectController extends \yii\web\Controller
{

	public $projectSimpleFormClass = 'app\models\ProjectSimpleForm';
	public $modelClass = 'app\models\Project';

	/**
	 * Simple create project
	 * 
	 * @return JSON output
	 */
	public function actionSimplecreate()
	{
		if (!Yii::$app->request->isAjax) {
			throw new MethodNotAllowedHttpException('Method Not Allowed.');
		}

		$response = [
			'success' => false
		];

		$model = new $this->projectSimpleFormClass;
		$model->load(Yii::$app->request->post());

		$errors = ActiveForm::validate($model);
		if (sizeof($errors)) {
			$response['errors'] = $errors;
		} else {
			if ($model->save(false)) {
				$response['success'] = true;
				$response['project'] = $model->model;
			}
		}

		$this->layout = null;
		Yii::$app->response->format = Response::FORMAT_JSON;
		return $response;
	}
	
	/**
	 * Lists all project's tasks
	 * @param int $id Project id
	 */
	public function actionTasks($id)
	{
		$this->render('tasks', [
			'projectModel' => $this->findModel($id)
		]);
	}

//	/**
//	 * Lists all Project models.
//	 * @return mixed
//	 */
//	public function actionIndex()
//	{
//		$searchModel = new ProjectSearch();
//		$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
//
//		return $this->render('index', [
//				'searchModel' => $searchModel,
//				'dataProvider' => $dataProvider,
//		]);
//	}

	/**
	 * Displays a single Project model with it tasks.
	 * @param integer $id
	 * @return mixed
	 */
	public function actionView($id)
	{
		return $this->render('view', [
				'model' => $this->findModel($id),
		]);
	}

//
//	/**
//	 * Creates a new Project model.
//	 * If creation is successful, the browser will be redirected to the 'view' page.
//	 * @return mixed
//	 */
//	public function actionCreate()
//	{
//		$model = new Project();
//
//		if ($model->load(Yii::$app->request->post()) && $model->save()) {
//			return $this->redirect(['view', 'id' => $model->id]);
//		} else {
//			return $this->render('create', [
//					'model' => $model,
//			]);
//		}
//	}
//
//	/**
//	 * Updates an existing Project model.
//	 * If update is successful, the browser will be redirected to the 'view' page.
//	 * @param integer $id
//	 * @return mixed
//	 */
//	public function actionUpdate($id)
//	{
//		$model = $this->findModel($id);
//
//		if ($model->load(Yii::$app->request->post()) && $model->save()) {
//			return $this->redirect(['view', 'id' => $model->id]);
//		} else {
//			return $this->render('update', [
//					'model' => $model,
//			]);
//		}
//	}
//
//	/**
//	 * Deletes an existing Project model.
//	 * If deletion is successful, the browser will be redirected to the 'index' page.
//	 * @param integer $id
//	 * @return mixed
//	 */
//	public function actionDelete($id)
//	{
//		$this->findModel($id)->delete();
//
//		return $this->redirect(['index']);
//	}

	/**
	 * Finds the Project model based on its primary key value.
	 * If the model is not found, a 404 HTTP exception will be thrown.
	 * @param integer $id
	 * @return Project the loaded model
	 * @throws NotFoundHttpException if the model cannot be found
	 */
	protected function findModel($id)
	{
		if (($model = Project::findOne($id)) !== null) {
			return $model;
		} else {
			throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
		}
	}

}
