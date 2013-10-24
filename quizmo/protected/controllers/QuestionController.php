<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


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
				'actions'=>array('create','update','delete','reorder','admindex'),
				'roles'=>array('admin','super'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @todo set the layout to ajax so the general layout doesn't do all the calls twice
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id='')
	{
		$question_id = $id;
		if(isset($_REQUEST['question_id']))
			$question_id = Yii::app()->getRequest()->getParam('question_id');
		$user_id = Yii::app()->user->getId();
		$isajax = Yii::app()->getRequest()->getParam('ajax');
		if($isajax)
			$this->layout = false;
		
		//$question = new Question;
		//$question = $question->model()->findByPk($id);
		$question = Question::getQuestionViewById($question_id, $user_id);
		$quiz_id = Question::getQuizId($question_id);
		
		$this->render('view',array(
			'question'=>$question,
			'quiz_id'=>$quiz_id,
			'collection_id'=>Quiz::getCollectionId($quiz_id),
			'isajax'=>$isajax
		));
	}

	/**
	 * Creates a new model
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 * @todo break out the massive switch statement into a model or component so it can be unit tested
	 */
	public function actionCreate($id='', $id2='')
	{
		$user_id = Yii::app()->user->getId();
		$quiz = new Quiz;
		//error_log("quiz/create");
		
		$quiz_id = $id;
		$question_id = $id2;
		$collection_id = Quiz::getCollectionId($quiz_id);

		$title = Yii::app()->getRequest()->getParam('title');
		$body = Yii::app()->getRequest()->getParam('body');
		$body = preg_replace("/<br>/", "<br/>", $body);
		$question_type = Yii::app()->getRequest()->getParam('question_type');
		$score = Yii::app()->getRequest()->getParam('score');
		$feedback = Yii::app()->getRequest()->getParam('feedback');
		// necessary for isites inserting spaces into empty input fields. right?
		// even though it appears to just be a space, the preg_match was required over a simple == ' '
		if(preg_match("/^\s+$/", $feedback)){
			$feedback = '';
		}
		$submit = Yii::app()->getRequest()->getParam('submitted');
				
		$question = array();
		$errors = array();
		if($submit){
			// for validation
			$has_correct = true;
		
			// lets put everything into question so it will show if the validation fails
			if($question_id == ''){
				$has_correct = false;
				$question['title'] = $title;
				$question['body'] = $body;
				// TODO: implement this: Question::typeStringToCode($question_type);
				//$question['question_type'] = Question::typeStringToCode($question_type);
				switch($question_type){
					case 'multiple':
						$question['question_type'] = 'M';
						$multiple_radio_answer = Yii::app()->getRequest()->getParam('multiple_radio_answer');
						for($i = 0; isset($_REQUEST['multiple_answer'.$i]); $i++){
							//error_log("$i:$multiple_radio_answer");
							($i == $multiple_radio_answer) ? $correct = 1 : $correct = 0;
							// for validation
							if($correct == 1)
								$has_correct = true;
							if($_REQUEST['multiple_answer'.$i] != ''){
								$question['answers'][$i]['answer'] = $_REQUEST['multiple_answer'.$i];
								$question['answers'][$i]['is_correct'] = $correct;
							}
						
						}
						break;
					case 'truefalse':
						$question['question_type'] = 'T';
						$truefalse = Yii::app()->getRequest()->getParam('truefalse');
						$has_correct = true;
						if($truefalse == 1){
							$question['answers'][0]['is_correct'] = 1;
							$question['answers'][1]['is_correct'] = 0;
						} elseif($truefalse == 0){
							$question['answers'][0]['is_correct'] = 0;
							$question['answers'][1]['is_correct'] = 1;
						} else {
							$has_correct = false;
						}
						$question['answers'][0]['answer'] = 'True';
						$question['answers'][1]['answer'] = 'False';
						break;
					case 'checkall':
						$question['question_type'] = 'S';

						$check_all_answers = array();
						for($i = 0; $i < 30; $i++){
							if(isset($_REQUEST['check_all_answer'.$i])){
								(isset($_REQUEST['check_all_check_answer'.$i])) ? $correct = 1 : $correct = 0;
								// for validation
								if($correct == 1)
									$has_correct = true;
								if(Yii::app()->getRequest()->getParam('check_all_answer'.$i) != ''){
									array_push($check_all_answers, array(
										'answer' => Yii::app()->getRequest()->getParam('check_all_answer'.$i),
										'is_correct' => $correct
									));								
								}
							}
						}

						for($i = 0; $i < sizeof($check_all_answers); $i++){
							if(isset($check_all_answers[$i]['answer'])){
								$question['answers'][$i]['is_correct'] = $check_all_answers[$i]['is_correct'];
								$question['answers'][$i]['answer'] = $check_all_answers[$i]['answer'];
							}
						}
						break;
					case 'essay':
						$question['question_type'] = 'E';
						break;
					case 'numerical':
						$question['question_type'] = 'N';
						$question['answers'][0]['answer'] = Yii::app()->getRequest()->getParam('numerical_answer');
						$question['answers'][0]['tolerance'] = Yii::app()->getRequest()->getParam('tolerance');				
						break;
					case 'fillin':
						$question['question_type'] = 'F';
						break;
					default:
						$question['question_type'] = '';
						break;
				}
				$question['points'] = $score;
				$question['feedback'] = $feedback;
			} else {
				$question = Question::getQuestionViewById($question_id);
			}
				
			// validation rules
			// if no title
			if($title == ''){
				$errors['no_title'] = 1;
			}
			// if no body
			if($body == ''){
				$errors['no_body'] = 1;
			}
			// if no question type
			if($question_type == ''){
				$errors['no_question_type'] = 1;
			}
			// if score isn't a number
			if(!is_numeric($score) && $score != ''){
				$errors['score_not_number'] = 1;
			}
			// if multiple choice has 0 answers
			if($question_type == 'multiple'){
				if(!isset($question['answers'])){
					$errors['multiple_no_answer'] = 1;
					// we don't need to report both of these errors at the same time
				} else {
					// if multiple choice has no selected correct answer
					if(!$has_correct){
						$errors['multiple_no_correct'] = 1;
					} 
				}
			}
			// if true false has no selected correct answer
			if($question_type == 'truefalse'){
				if(!$has_correct){
					$errors['truefalse_no_correct'] = 1;
				}
			}
			// if multiple selection has 0 answers
			if($question_type == 'checkall'){
				if(!isset($question['answers'])){
					$errors['checkall_no_answer'] = 1;
				} else {
					// if multiple selection has no selected correct answer
					if(!$has_correct){
						$errors['checkall_no_correct'] = 1;
					} 			
				}
			}
			// if numerical isn't a valid number
			if($question_type == 'numerical'){
				$tolerance = Yii::app()->getRequest()->getParam('tolerance');
				$numerical_answer = Yii::app()->getRequest()->getParam('numerical_answer');
				if(!is_numeric($numerical_answer)){
					$errors['numerical_not_number'] = 1;
				} else {
					// if tolerence isn't a valid number
					if(!is_numeric($tolerance)){
						$errors['tolerance_not_number'] = 1;
					}
				}
			}
			// if fillin doesn't have a {fillin}
			if($question_type == 'fillin'){
				if(!preg_match("/\{.+\}/", $body)){
					$errors['fillin_no_answer'] = 1;
				}
			}	
		}	

		// else it's a create
		if($title != '' && $body != '' && $question_type != '' && sizeof($errors) == 0){
			// this needs to be put into the question model or its own component so a unit test can be written on it
			if($question_id != ''){
				$question = Question::model()->findByPk($question_id);
			} else {
				$question = new Question;					
			}
			switch($question_type){
				// **********************************************************************
				case 'multiple':
					$multiple_radio_answer = Yii::app()->getRequest()->getParam('multiple_radio_answer');
					$multiple_answers = array();
					// isset() won't work with the yii->getParam
					// This produces an array of the form:
					// array(
					//		array(
					//			'answer' => 'some answer',
					//			'is_correct' => 1
					//		), ...
					//	)
					for($i = 0; isset($_REQUEST['multiple_answer'.$i]); $i++){
						($i == $multiple_radio_answer) ? $correct = 1 : $correct = 0;
						array_push($multiple_answers, array(
							'answer' => Yii::app()->getRequest()->getParam('multiple_answer'.$i),
							'is_correct' => $correct
						));
					}
					// Maybe this should be moved to the model?
					// ANSWER: No.  It is just getting params, that cannot be moved to the model
					//Answer::multipleChoiceAnswers($multiple_radio_answer, )
					$question_id = $question->createMultipleChoice($quiz_id, Question::MULTIPLE_CHOICE, $title, $body, $score, $feedback, $multiple_answers);
					break;
				// **********************************************************************

				case 'truefalse':
					$truefalse = Yii::app()->getRequest()->getParam('truefalse');
					$question_id = $question->createTrueFalse($quiz_id, $title, $body, $score, $feedback, $truefalse);
					break;
				// **********************************************************************

				case 'checkall':
					// The problem with this is if the check isn't checked, it won't show in the POST
					// so let's just go up to 20
					// This produces an array of the form:
					// array(
					//		array(
					//			'answer' => 'some answer',
					//			'is_correct' => 1
					//		), ...
					//	)
					$check_all_answers = array();
					for($i = 0; $i < 30; $i++){
						if(isset($_REQUEST['check_all_answer'.$i])){
							(isset($_REQUEST['check_all_check_answer'.$i])) ? $correct = 1 : $correct = 0;
							array_push($check_all_answers, array(
								'answer' => Yii::app()->getRequest()->getParam('check_all_answer'.$i),
								'is_correct' => $correct
							));
						}
					}

					$question_id = $question->createMultipleChoice($quiz_id, Question::MULTIPLE_SELECTION, $title, $body, $score, $feedback, $check_all_answers);
					break;
				// **********************************************************************

				case 'essay':
					$textarea_rows = Yii::app()->getRequest()->getParam('textarea_rows');
					$question_id = $question->createEssay($quiz_id, $title, $body, $score, $feedback, $textarea_rows);
					break;
				// **********************************************************************

				case 'numerical':
					$tolerance = Yii::app()->getRequest()->getParam('tolerance');
					$numerical_answer = Yii::app()->getRequest()->getParam('numerical_answer');
					$question_id = $question->createNumerical($quiz_id, $title, $body, $score, $feedback, $numerical_answer, $tolerance);
					break;
				// **********************************************************************

				case 'fillin':
					(isset($_REQUEST['is_case_sensitive'])) ? $is_case_sensitive = 1 : $is_case_sensitive = 0;
					$question_id = $question->createFillin($quiz_id, $title, $body, $score, $feedback, $is_case_sensitive);
					break;
				// **********************************************************************


				default:
					error_log("unknown question type: $question_type");
					break;

			}
			//$question_id = $quiz->create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback);
			if(@$question_id != ''){
				// now go to list
				//$this->forward('/question/index/'.$quiz_id);
				//$this->jsredirect($this->url('/question/admindex/'.$quiz_id));
				$this->layout = false;
				echo json_encode(array('success'=>true, 'question_id'=>$question_id, 'errors'=>$errors));
				Yii::app()->end();			
				return;
			}
		}
		
		if($question_id != ''){
			$question = Question::getQuestionViewById($question_id);
		}

		if($submit){
			$this->layout = false;
			echo json_encode(array('success'=>true, 'question_id'=>$question_id, 'errors'=>$errors));
			Yii::app()->end();			
		}
		
		$this->render('create', array(
			'collection_id'=>$collection_id,
			'quiz_id'=>$quiz_id,
			'title'=>$title,
			'body'=>$body,
			'question_type'=>$question_type,
			'question_id'=>$question_id,
			'question'=>$question,
			'error_json'=>json_encode($errors),
			'quiz_title'=>htmlentities(Quiz::model()->findByPk($quiz_id)->TITLE),
		));
		
	}


	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete()
	{
		$this->layout = false;
		$question_id = Yii::app()->getRequest()->getParam('question_id');
		
		if(!Question::setDeleted($question_id))
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');

		echo json_encode(array('question_id'=>$question_id));
		Yii::app()->end();

	}

	/**
	 * Lists all models.
	 */
	public function actionAdmindex($id='')
	{
		$quiz_id = ($id=='') ? Yii::app()->session['quiz_id'] : $id;
		//$collection_id = Yii::app()->session['collection_id'];
		$collection_id = Quiz::getCollectionId($quiz_id);
		Yii::app()->session['quiz_id'] = $quiz_id;
		$user_id = Yii::app()->user->id;
		$questions = Question::getQuestionArrayByQuizId($quiz_id);
		$topic_id = Yii::app()->getRequest()->getParam('topicId');

		$this->render('admindex',array(
			'collection_id'=>$collection_id,
			'questions'=>$questions,
			'sizeofquestions'=>sizeof($questions),
			'user_id'=>$user_id,
			'quiz_id'=>$quiz_id,
			'title'=>htmlentities(Quiz::model()->findByPk($quiz_id)->TITLE),
			'topic_id'=>$topic_id,
		));

	}
	
	/**
	 * Lists all models.
	 */
	public function actionIndex($id='')
	{
		$quiz_id = ($id=='') ? Yii::app()->session['quiz_id'] : $id;
		//$collection_id = Yii::app()->session['collection_id'];
		$collection_id = Quiz::getCollectionId($quiz_id);
		Yii::app()->session['quiz_id'] = $quiz_id;
		$user_id = Yii::app()->user->id;
		$questions = Question::getQuestionArrayByQuizId($quiz_id);
		$questions_answered = Response::getQuestionsAnsweredByQuizIdUserId($quiz_id, $user_id);
		
		$this->render('index',array(
			'collection_id'=>$collection_id,
			'questions'=>$questions,
			'sizeofquestions'=>sizeof($questions),
			'user_id'=>$user_id,
			'quiz_id'=>$quiz_id,
			'title'=>htmlentities(Quiz::model()->findByPk($quiz_id)->TITLE),
			'questions_answered'=>$questions_answered,
		));

	}
	
	/**
	 * for reordering a question
	 * called from the datatable reordering function
	 */
	public function actionReorder(){
		//error_log("question reorder");
		$question_id = Yii::app()->getRequest()->getParam('id');
		$fromPosition = Yii::app()->getRequest()->getParam('fromPosition');
		$toPosition = Yii::app()->getRequest()->getParam('toPosition');

		// set the reorder for this quiz_id
		Question::reorder($question_id, $fromPosition, $toPosition);
	
	}
	


}
