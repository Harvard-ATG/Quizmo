<?php
/**
* SubmissionTest unit test
*
* 
*/
class SubmissionTest extends CDbTestCase {
   
	

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


   
}
