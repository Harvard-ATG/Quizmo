<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


class ResponseController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('submitQuestion'),
				'roles'=>array('enrollee','admin','super'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('grade','delete'),
				'roles'=>array('admin','super'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionSubmitQuestion()
	{
		//error_log("actionSubmitQuestion");
		$this->layout = false;
		$user_id = Yii::app()->user->getId();
		$question_id = Yii::app()->getRequest()->getParam('question_id');
		$answer_id = Yii::app()->getRequest()->getParam('answer_id');
		$answer = Yii::app()->getRequest()->getParam('answer');
		$answers = Yii::app()->getRequest()->getParam('answers');
		$question_type = Yii::app()->getRequest()->getParam('question_type');
		
		switch($question_type){
			case Question::MULTIPLE_CHOICE:
				$response = Response::submitMultipleChoiceQuestion($user_id, $question_type, $question_id, $answer_id);
			break;
			case Question::TRUE_FALSE:
				$response = Response::submitMultipleChoiceQuestion($user_id, $question_type, $question_id, $answer_id);
			break;
			case Question::ESSAY:
				$response = Response::submitEssayQuestion($user_id, $question_id, $answer);
			break;
			case Question::NUMERICAL:
				$response = Response::submitNumericalQuestion($user_id, $question_id, $answer);
			break;
			case Question::MULTIPLE_SELECTION:
				// set the answers
				// submit the answers
				$response = Response::submitMultipleSelectionQuestion($user_id, $question_id, $answers);
			break;
			case Question::FILLIN:
				// set the answers
				// submit the answers
				$response = Response::submitFillinQuestion($user_id, $question_id, $answers);
			break;
			
			
		}
			
		Yii::app()->end();
	}
	
	/**
	 * grade response
	 */
	public function actionGrade(){
		//error_log("actionGrade");
		$this->layout = false;
		$response_id = Yii::app()->getRequest()->getParam('response_id');
		$user_id = Yii::app()->getRequest()->getParam('user_id');
		$score = Yii::app()->getRequest()->getParam('score');
		//error_log($score);
		Response::setScore($response_id, $score);
		
	}

	/**
	 * Sets the flag as deleted
	 */
	public function actionDelete()
	{
		$this->layout = false;
		$quiz_id = Yii::app()->getRequest()->getParam('quiz_id');
		$user_id = Yii::app()->getRequest()->getParam('user_id');
		
		if($quiz_id != '' && $user_id != ''){
			Response::deleteByQuizIdUserId($quiz_id, $user_id);
			echo json_encode(array('quiz_id'=>$quiz_id, 'user_id'=>$user_id));
			Yii::app()->end();
		} else {
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
		}

		
	}

}
