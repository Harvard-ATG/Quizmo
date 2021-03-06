<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

/**
* SubmissionTest unit test
*
* 
*/
class SubmissionTest extends CDbTestCase {
   
	public $fixtures=array(
		'collections'=>'Collection',
		'users'=>'User',
		'userscollections'=>'UsersCollection',
		'quizzes'=>'Quiz',
		'questions'=>'Question',
		'responses'=>'Response',
		'submissions'=>'Submission',
	);

	public function testStartQuiz(){
		$quiz_id = 1;
		$user_id = 4;

		// first make sure it doesn't already exist
		$submission = Submission::model()->find('user_id=:user_id AND quiz_id=:quiz_id', 
			array(
				':user_id' => $user_id,			
				':quiz_id' => $quiz_id,			
			)
		);
		$this->assertNull($submission);
		
		// then do startQuiz
		Submission::startQuiz($user_id, $quiz_id);
		
		// then check that it's there
		$submission = Submission::model()->find('user_id=:user_id AND quiz_id=:quiz_id', 
			array(
				':user_id' => $user_id,			
				':quiz_id' => $quiz_id,			
			)
		);
		$this->assertNotNull($submission);
		
		
		// then delete
		$submission->delete();

	}
	
	public function testSubmitQuiz(){
		$quiz_id = 1;
		$user_id = 4;
		
		// first make sure it doesn't exist already
		$submission = Submission::model()->find('user_id=:user_id AND quiz_id=:quiz_id', 
			array(
				':user_id' => $user_id,			
				':quiz_id' => $quiz_id,			
			)
		);
		$this->assertNull($submission, "exists when it shouldn't");
		
		// try to submit when it doesn't already exist
		// should return false
		$this->assertFalse(Submission::submitQuiz($user_id, $quiz_id));
		
		// then set it via startQuiz
		Submission::startQuiz($user_id, $quiz_id);
		
		// try to submit again,
		// should pass since it now exists as started
		$this->assertTrue(Submission::submitQuiz($user_id, $quiz_id));
		
		// then check that it's set
		$submission = Submission::model()->find('user_id=:user_id AND quiz_id=:quiz_id', 
			array(
				':user_id' => $user_id,			
				':quiz_id' => $quiz_id,			
			)
		);
		$this->assertEquals(Submission::SUBMITTED, $submission->STATUS);
		
		// then delete
		$submission->delete();
		
	}
	
	public function testGetStatusByUser(){
		$user_id = 2;
		$quiz_id = 1;
		$submission_status = Submission::SUBMITTED;
		
		$this->assertEquals($submission_status, Submission::getStatusByUser($user_id, $quiz_id));
		
	}
	
	public function testIsSubmitted(){
		$user_id_true = 2;
		$user_id_false = 1;
		$quiz_id = 1;
		$this->assertTrue(Submission::isSubmitted($user_id_true, $quiz_id));
		$this->assertFalse(Submission::isSubmitted($user_id_false, $quiz_id));
		
	}

	public function shouldReturnNotStarted(){
		$user_id = 1;
		$submission_status = Submission::NOT_STARTED;
		
		$this->assertEquals($submission_status, Submission::getStatusByUser($user_id, $quiz_id));
		
	}
	
	public function testGetResultTotals(){
		$collection_id = 1;
		$total_number_of_quizzes = 4;
		$submitted = 1;
		$total = 2;
		// get result
		$result = Submission::getResultTotals($collection_id);
		// make sure total number of quizzes is right
		$this->assertEquals($total_number_of_quizzes, sizeof($result));
		// make sure submitted is right
		$this->assertEquals($submitted, $result[$collection_id]['submitted']);
		// make sure total is right
		$this->assertEquals($total, $result[$collection_id]['total']);
	}
   
}
