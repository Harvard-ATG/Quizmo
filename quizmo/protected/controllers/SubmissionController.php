<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


class SubmissionController extends Controller
{

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
				'actions'=>array('isSubmitted'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionIsSubmitted(){
		$this->layout = false;
		$user_id = Yii::app()->user->id;
		$quiz_id = Yii::app()->getRequest()->getParam('quiz_id');
		
		$success = Submission::isSubmitted($user_id, $quiz_id);
		if($success){
			Yii::app()->session['banner_message'] = "Quiz already submitted.";
		}
		header('Content-type: application/json');
		echo json_encode(array('success'=>$success, 'user_id'=>$user_id));
		Yii::app()->end();
		
	}

}
