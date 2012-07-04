<?php

class QuizController extends Controller
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
				'actions'=>array('create','update','take', 'edit'),
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
	 *
	 * @param number $id refers to the collection_id
	 */
	public function actionCreate($id='')
	{
		$quiz = new Quiz;
		//error_log("quiz/create");
		$collection_id = ($id == '') ? Yii::app()->session['collection_id'] : $id;
		$collection_id = ($collection_id == '') ? Yii::app()->getRequest()->getParam('collection_id') : $collection_id;
		if($collection_id != '') Yii::app()->session['collection_id'] = $collection_id;
		$title = Yii::app()->getRequest()->getParam('title');
		$description = Yii::app()->getRequest()->getParam('description');
		$state = Yii::app()->getRequest()->getParam('state');
		$start_date = Yii::app()->getRequest()->getParam('start_date');
		$end_date = Yii::app()->getRequest()->getParam('end_date');
		$visibility = Yii::app()->getRequest()->getParam('visibility');
		if($visibility == '') $visibility = 0;
		$show_feedback = Yii::app()->getRequest()->getParam('show_feedback');
		if($show_feedback == '') $show_feedback = 0;
		$user_id = Yii::app()->user->getId();


		if($title != ''){
			
			//$collection_id = Yii::app()->getRequest()->getParam('collection_id');
			$quiz_id = $quiz->create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback);
			if($quiz_id != ''){
				// now go to list
				$this->forward('/quiz/index/'.$collection_id, true);

			}
		}

		$this->render('create', array(
			'collection_id'=>$collection_id,
			'title'=>$title,
			'description'=>$description,
			'state'=>$state,
			'start_date'=>$start_date,
			'end_date'=>$end_date,
			'visibility'=>$visibility,
			'show_feedback'=>$show_feedback,
		));

	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 *
	 * @param string $id refers to the quiz_id
	 * @todo implement quiz::edit
	 */
	public function actionEdit($id='')
	{
		$quiz = new Quiz;
		//error_log("quiz/create");
		$quiz_id = $id;
		$title = Yii::app()->getRequest()->getParam('title');
		$description = Yii::app()->getRequest()->getParam('description');
		$state = Yii::app()->getRequest()->getParam('state');
		$start_date = Yii::app()->getRequest()->getParam('start_date');
		$end_date = Yii::app()->getRequest()->getParam('end_date');
		$visibility = Yii::app()->getRequest()->getParam('visibility');
		if($visibility == '') $visibility = 0;
		$show_feedback = Yii::app()->getRequest()->getParam('show_feedback');
		if($show_feedback == '') $show_feedback = 0;
		$user_id = Yii::app()->user->getId();
		
		
		// if we're submitted, we'll have a title set here
		if($title != ''){
			
			//$collection_id = Yii::app()->getRequest()->getParam('collection_id');
			//$quiz_id = $quiz->create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback);
			if($quiz_id != ''){
				// now go to list
				$this->forward('/quiz/index/'.$collection_id, true);

			}
		}

		// TODO
		// set values here
		if($quiz_id != ''){
			$collection_id = "1";
			
		}


		$this->render('edit', array(
			'collection_id'=>$collection_id,
			'quiz_id'=>$quiz_id,
			'title'=>$title,
			'description'=>$description,
			'state'=>$state,
			'start_date'=>$start_date,
			'end_date'=>$end_date,
			'visibility'=>$visibility,
			'show_feedback'=>$show_feedback,
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

		if(isset($_POST['Quiz']))
		{
			$model->attributes=$_POST['Quiz'];
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
	* @param $id => in this case, $id refers to collection_id
	 */
	public function actionIndex($id='')
	{
		error_log("quiz/index");
		$collection_id = ($id=='') ? Yii::app()->session['collection_id'] : $id;
		$user_id = Yii::app()->user->id;
		$quizes = Quiz::getQuizArrayByCollectionId($collection_id);
		$this->render('index',array(
			//'dataProvider'=>$dataProvider,
			'quizes'=>$quizes,
			'sizeofquizes'=>sizeof($quizes),
			'user_id'=>$user_id,
			'collection_id'=>$collection_id,
		));
		
	}
	
	public function actionTake($id=''){
		$quiz_id = $id;
		$user_id = Yii::app()->user->id;
		
		// first we set the session quiz_id
		// then we forward along to the question Take view
		// OR we just go into this and flip through it via ajax
		
		// let's start with the ajax approach...
		// for that we need to get a list of all question ids in the quiz
		$question_ids = Quiz::getQuestionIds($quiz_id);
		
		$this->render('take', array(
			'question_ids_json'=>json_encode($question_ids),
			'question_ids'=>$question_ids,
			'user_id'=>$user_id
			
		));
		
		
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Quiz('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Quiz']))
			$model->attributes=$_GET['Quiz'];

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
		$model=Quiz::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='quiz-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
