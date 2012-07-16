<?php
/**
* ResponseTest unit test
*
* 
*/
class ResponseTest extends CDbTestCase {
   
	public $fixtures=array(
		'answers'=>'Answer',
		'responses'=>'Response'
	);

	public function testSubmitEssayQuestion(){
		$question_id = 1;
		$user_id = 5;
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
	
	public function testSubmitNumericalQuestion(){
		$question_id = 1;
		$user_id = 5;
		$response_text = 3.4;

		// first make sure it doesn't already exist
		$response = Response::model()->find('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		$this->assertNull($response);
		
		// then submit the question
		$this->assertTrue(Response::submitNumericalQuestion($user_id, $question_id, $response_text));
		
		// then check that it's there
		// with the type set
		// with only one
		$response = Response::model()->find('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		$this->assertEquals($response->QUESTION_TYPE, Question::NUMERICAL);
		$this->assertEquals(count($response), 1);
		
		// then delete
		$response->delete();

	}

	public function testSubmitMultipleSelectionQuestion(){
		$question_id = 6;
		$user_id = 5;
		$answer_array = array(
			9, 10, 11
		);

		// first make sure it doesn't already exist
		$responses = Response::model()->findAll('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		$this->assertEquals(count($responses), 0);
		
		// then submit the question's answers
		$this->assertTrue(Response::submitMultipleSelectionQuestion($user_id, $question_id, $answer_array));			
		
		// then check that it's there
		// with the type set
		// with the right number of them
		$responses = Response::model()->findAll('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		
		
		foreach($responses as $response){
			$this->assertEquals($response->QUESTION_TYPE, Question::MULTIPLE_SELECTION);			
		}
		$this->assertEquals(count($responses), count($answer_array));
		
		// then delete them all
		foreach($responses as $response){
			$response->delete();			
		}

	}

	public function testSubmitMultipleChoiceQuestion(){
		$question_id = 1;
		$question_type = Question::MULTIPLE_CHOICE;
		$user_id = 5;
		$answer_id = 1;

		// first make sure it doesn't already exist
		$response = Response::model()->find('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		$this->assertNull($response);
		
		// then submit the question's answers
		$this->assertTrue(Response::submitMultipleChoiceQuestion($user_id, $question_type, $question_id, $answer_id));			
		
		// then check that it's there
		// with the type set
		// with only 1
		$responses = Response::model()->findAll('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		
		
		foreach($responses as $response){
			$this->assertEquals($response->QUESTION_TYPE, Question::MULTIPLE_CHOICE);			
		}
		$this->assertEquals(count($responses), 1);
		
		// then delete them all
		foreach($responses as $response){
			$response->delete();			
		}

	}

	public function testSubmitFillinQuestion(){
		$question_id = 8;
		$user_id = 5;
		$answers = array(
			"lime", "coconut", "drink"
		);

		// first make sure it doesn't already exist
		$response = Response::model()->find('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		$this->assertNull($response);
		
		// then submit the question's answers
		$this->assertTrue(Response::submitFillinQuestion($user_id, $question_id, $answers));			
		
		// then check that it's there
		// with the type set
		// with 3 responses
		$responses = Response::model()->findAll('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);
		
		
		foreach($responses as $response){
			$this->assertEquals($response->QUESTION_TYPE, Question::FILLIN);			
		}
		$this->assertEquals(count($responses), 3);
		
		// then delete them all
		foreach($responses as $response){
			$response->delete();			
		}

	}
	
	function testGetResults(){
		$quiz_id = 1;
		$count = 3;
		
		// get the results
		$results = Response::getResults($quiz_id);
		// assert that there are 3 people in the results 
		$this->assertEquals($count, sizeof($results));
		// assert that results have a name, score and status
		foreach($results as $result){
			$this->assertNotNull($result['name']);
			$this->assertNotNull($result['score']);
			$this->assertNotNull($result['status']);
		}
	}
	
	public function testGetTotalScoreByUser(){
		$user_id = 2;
		$score = 8;
		
		$this->assertEquals($score, Response::getTotalScoreByUser($user_id));
	}

   
}
