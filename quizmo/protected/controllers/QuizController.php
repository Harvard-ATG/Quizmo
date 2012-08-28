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
			array('allow', // guests can't take
				'actions'=>array('take','individualResults','totalScore'),
				'roles'=>array('enrollee','admin','super')
			),
			array('allow', // guests can't take
				'actions'=>array('create','update','edit','results','submit','delete'),
				'roles'=>array('admin','super')
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
	public function actionCreate($id='', $id2='')
	{
		$quiz = new Quiz;
		//error_log("quiz/create");
		//$collection_id = ($id == '') ? Yii::app()->session['collection_id'] : $id;
		//$collection_id = ($collection_id == '') ? Yii::app()->getRequest()->getParam('collection_id') : $collection_id;
		//if($collection_id != '') Yii::app()->session['collection_id'] = $collection_id;
		$collection_id = $id;
		$quiz_id = $id2;
		
		$title = Yii::app()->getRequest()->getParam('title');
		$description = Yii::app()->getRequest()->getParam('description');
		$state = Yii::app()->getRequest()->getParam('quiz_state');
		$start_date = Yii::app()->getRequest()->getParam('start_date');
		$end_date = Yii::app()->getRequest()->getParam('end_date');
		$visibility = Yii::app()->getRequest()->getParam('visibility');
		if($visibility == '') $visibility = 0;
		$show_feedback = Yii::app()->getRequest()->getParam('show_feedback');
		if($show_feedback == '') $show_feedback = 0;
		$user_id = Yii::app()->user->getId();

		// if quiz_id isset, this is an edit
		if($quiz_id != ''){
			// findByPk the quiz
			$quiz = Quiz::model()->findByPk($quiz_id);
			if(isset($_REQUEST['title'])){
				// set the ID
				$quiz->ID = $quiz_id;
				// perform create/edit with the request params
				$quiz_id = $quiz->create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback);
				$this->jsredirect($this->url('/quiz/index/'.$collection_id));
				
			} else {
				// get all elements to send back
				$title = $quiz->TITLE;
				$description = $quiz->DESCRIPTION;
				$state = $quiz->STATE;
				$start_date = $quiz->START_DATE;
				$end_date = $quiz->END_DATE;
				$visibility = $quiz->VISIBILITY;
				$show_feedback = $quiz->SHOW_FEEDBACK;					
			}
			
		} else {
			// if there's no quiz_id, but there is a title, then it's ready to be set
			if($title != ''){

				//$collection_id = Yii::app()->getRequest()->getParam('collection_id');
				$quiz_id = $quiz->create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback);
				// if there's a quiz_id now, it's done creating
				if($quiz_id != ''){
					// now go to list
					//$this->forward('/quiz/index/'.$collection_id, true);
					$this->jsredirect($this->url('/question/index/'.$quiz_id));
				}
			}						
			
		}



		$this->render('create', array(
			'quiz_id'=>$quiz_id,
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
				//$this->forward('/quiz/index/'.$collection_id, true);
				$this->jsredirect($this->url('/quiz/index/'.$collection_id));

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
	 * Sets the flag as deleted
	 */
	public function actionDelete()
	{
		$this->layout = false;
		$quiz_id = Yii::app()->getRequest()->getParam('quiz_id');
		
		if(!Quiz::setDeleted($quiz_id))
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

		echo json_encode(array('quiz_id'=>$quiz_id));
		Yii::app()->end();
		
	}

	/**
	* Lists all models.
	* @param $id => in this case, $id refers to collection_id
	 */
	public function actionIndex($id='',$id2='')
	{
		//error_log("quiz/index/".$id);
		$collection_id = $id;
		$force_index = $id2;
		$user_id = Yii::app()->user->id;
		$quizzes = Quiz::getQuizArrayByCollectionId($collection_id, $user_id);
		$perm_id = Yii::app()->user->perm_id;
		if($perm_id >= UserIdentity::ADMIN){
			$admin = true;
		}
		
		if($admin && $force_index == ''){
			$this->render('admindex',array(
				//'dataProvider'=>$dataProvider,
				'quizzes'=>$quizzes,
				'sizeofquizzes'=>sizeof($quizzes),
				'user_id'=>$user_id,
				'collection_id'=>$collection_id,
			));
		} else {
			$this->render('index',array(
				//'dataProvider'=>$dataProvider,
				'admin'=>$admin,
				'quizzes'=>$quizzes,
				'sizeofquizzes'=>sizeof($quizzes),
				'user_id'=>$user_id,
				'collection_id'=>$collection_id,
			));

		}			
		
	}
	
	/**
	 * action for taking a quiz
	 *
	 * this should start a submission for the user/quiz pair 
	 * and send along a list of questions for the view to grab via ajaxification
	 * 
	 * @param number $id quiz_id
	 */
	public function actionTake($id=''){
		$quiz_id = $id;
		$user_id = Yii::app()->user->id;
		
		// first we set the session quiz_id
		// then we forward along to the question Take view
		// OR we just go into this and flip through it via ajax
		
		// let's start with the ajax approach...
		// for that we need to get a list of all question ids in the quiz
		$question_ids = Quiz::getQuestionIds($quiz_id);
		
		// mark the quiz as started for the user
		Submission::startQuiz($user_id, $quiz_id);
		
		$this->render('take', array(
			'question_ids_json'=>json_encode($question_ids),
			'question_ids'=>$question_ids,
			'user_id'=>$user_id,
			'quiz_id'=>$quiz_id,
			'collection_id'=>Quiz::getCollectionId($quiz_id)
		));
		
	}
	
	/**
	 * submits a quiz for scoring
	 * @param number $id quiz_id
	 */
	public function actionSubmit($id){
		$quiz_id = $id;
		$user_id = Yii::app()->user->id;
		
		Submission::submitQuiz($user_id, $quiz_id);
		Response::gradeQuiz($user_id, $quiz_id);
		
		$this->jsredirect($this->url('/quiz/individualResults/'.$quiz_id."/".$user_id));
	
	 }
	
	/**
	 * total results
	 * @param number $id
	 */
	public function actionResults($id){	
		
		$results = Response::getResults($id);	
		
		$this->render('results', array(
			'quiz_id'=>$id,
			'collection_id'=>Quiz::getQuiz($id)->COLLECTION_ID,
			'results'=>$results
		));
	}

	/**
	 * total results for an individual
	 * @param number $id quiz_id
	 * @param number $id2 user_id
	 */
	public function actionIndividualResults($id, $id2){	
		
		$quiz_id = $id;
		$user_id = $id2;
		
		switch(Submission::getStatusByUser($user_id, $quiz_id)){
			case Submission::NOT_STARTED:
				$status = "Not Started";
			break;
			case Submission::STARTED:
				$status = "Started / Unfinished";
			break;
			case Submission::SUBMITTED:
				$status = "Submitted";
			break;
			case Submission::GRADED:
				$status = "Finished / Graded";
			break;
			default:
				$status = "Error: unknown submission status: ".Submission::getStatusByUser($user_id, $quiz_id);
			break;
		}
		
		$this->render('individual_results', array(
			'user_id'=>$user_id,
			'quiz_id'=>$quiz_id,
			'name'=>User::getName($user_id),
			'status'=>$status,
			'score'=>Response::getTotalScoreByUser($user_id, $quiz_id),
			'total_score'=>Question::getTotalScore($quiz_id),
			'collection_id'=>Quiz::getQuiz($quiz_id)->COLLECTION_ID,
			'question_ids'=>Quiz::getQuestionIds($quiz_id),
			'questions'=>Question::getQuestionViewsByQuizId($quiz_id, $user_id),
			'host'=>"http://".$_SERVER['HTTP_HOST'],
		));
	}
	
	/**
	 * this handles the view for the score on the individual_results page
	 */
	public function actionTotalScore(){
		
		$user_id = Yii::app()->getRequest()->getParam('user_id');
		$quiz_id = Yii::app()->getRequest()->getParam('quiz_id');
		
		$this->render('total_score',array(
			'score'=>Response::getTotalScoreByUser($user_id, $quiz_id),
			'total_score'=>Question::getTotalScore($quiz_id)
		));
	}


}
