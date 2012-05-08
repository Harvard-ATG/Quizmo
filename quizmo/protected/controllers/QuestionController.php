<?php

class QuestionController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	//public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id='')
	{
		$quiz = new Quiz;
		//error_log("quiz/create");
		$quiz_id = ($id == '') ? Yii::app()->session['quiz_id'] : $id;
		Yii::app()->session['quiz_id'] = $quiz_id;
		error_log($quiz_id);
		$title = Yii::app()->getRequest()->getParam('title');
		$body = Yii::app()->getRequest()->getParam('body');
		$question_type = Yii::app()->getRequest()->getParam('question_type');
		$score = Yii::app()->getRequest()->getParam('score');
		$feedback = Yii::app()->getRequest()->getParam('feedback');
		$multiple_radio_answer = Yii::app()->getRequest()->getParam('multiple_radio_answer');
		

		$multiple_answers = array();
		$count = 1;
		while(!isset(Yii::app()->getRequest()->getParam('multiple_answer'.$count++))){
			array_push($multiple_answers, Yii::app()->getRequest()->getParam('multiple_answer'.$count));
		}
		
		
		$user_id = Yii::app()->user->getId();

		error_log(var_export($_POST, 1));


		if($title != ''){
			//$quiz_id = $quiz->create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback);
			//if($quiz_id != ''){
				// now go to list
			//	$this->redirect('index');
			//	return;
			//}
		}

		$this->render('create', array(
			'quiz_id'=>$quiz_id,
			'title'=>$title,
			'body'=>$body,
			'question_type'=>$question_type,
		));

	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Question']))
		{
			$model->attributes=$_POST['Question'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex($id='')
	{
		$quiz_id = ($id=='') ? Yii::app()->session['quiz_id'] : $id;
		Yii::app()->session['quiz_id'] = $quiz_id;
		$user_id = Yii::app()->user->id;
		$questions = Question::getQuestionArrayByQuizId($quiz_id);
		$this->render('index',array(
			//'dataProvider'=>$dataProvider,
			'questions'=>$questions,
			'sizeofquestions'=>sizeof($questions),
			'user_id'=>$user_id,
			'quiz_id'=>$quiz_id,
		));
		
		//$dataProvider=new CActiveDataProvider('Question');
		//$this->render('index',array(
		//	'dataProvider'=>$dataProvider,
		//));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Question('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Question']))
			$model->attributes=$_GET['Question'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Question::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='question-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
