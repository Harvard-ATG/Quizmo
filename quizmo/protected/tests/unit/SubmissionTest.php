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


   
}
