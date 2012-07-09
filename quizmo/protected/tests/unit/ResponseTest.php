<?php
/**
* ResponseTest unit test
*
* 
*/
class ResponseTest extends CDbTestCase {
   
	

	public function testSubmitEssayQuestion(){
		$question_id = 1;
		$user_id = 4;
		$response_text = "this is an essay";

		// first make sure it doesn't already exist
		$response = Response::model()->find('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		$this->assertNull($response);
		
		// then submit the question
		$this->assertTrue(Response::submitEssayQuestion($user_id, $question_id, $response_text));
		
		// then check that it's there
		// with the type set
		// with only one
		$response = Response::model()->find('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		$this->assertEquals($response->QUESTION_TYPE, Question::ESSAY);
		$this->assertEquals(count($response), 1);
		
		// then delete
		$response->delete();

	}
	



   
}
