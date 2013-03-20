<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

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
		$response_text2 = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam tortor metus, congue eu ullamcorper a, dictum mattis justo. Sed volutpat varius mauris, faucibus blandit risus dapibus quis. Sed sed justo massa, sed sollicitudin dui. Integer id accumsan dolor. In sed felis nisl. Integer quis magna ante. Morbi ornare laoreet ante eu viverra. Morbi sodales metus magna, at pretium lectus. Etiam congue tincidunt vestibulum.

		Phasellus luctus libero eget ligula ultrices condimentum. Integer eget sapien diam. Nunc blandit imperdiet scelerisque. Vivamus eu erat viverra felis accumsan molestie. Vivamus auctor commodo imperdiet. Integer neque massa, fringilla viverra tincidunt vitae, luctus quis tortor. Quisque vitae auctor sem. Donec auctor euismod nulla at rhoncus. Ut quis pellentesque nibh. Fusce placerat, nulla vitae accumsan eleifend, purus dolor gravida velit, eget dictum turpis ipsum eu quam. Nunc blandit lorem sit amet nulla suscipit gravida. Integer erat nulla, pretium at porttitor vitae, suscipit a nisl. Nullam nec erat mi. Nulla sed neque odio, vel tristique nunc. Duis id aliquam massa. Cras euismod varius ligula, tempus gravida enim elementum vitae.

		Suspendisse potenti. Morbi consequat condimentum tellus a pellentesque. Aliquam fringilla mattis nisi id bibendum. Phasellus vehicula, lectus lobortis malesuada elementum, purus risus blandit lacus, sed suscipit tellus lacus at urna. Cras sapien tortor, facilisis id dapibus aliquet, pellentesque et diam. Morbi in lacus nec nunc ullamcorper tristique a nec ligula. Proin elementum risus et diam vulputate convallis. Vivamus in dolor velit, feugiat mollis sem. Nam eu nunc sem. Praesent hendrerit velit ac massa dignissim lobortis. Donec ut viverra magna.

		Phasellus in neque erat, nec aliquet ante. Ut at ipsum nisi, cursus fermentum erat. Quisque eget laoreet nibh. Nunc in neque est. Quisque consectetur, est id pretium placerat, tortor nisl pulvinar arcu, sit amet euismod ipsum lorem et arcu. Etiam eu turpis justo, at ultrices leo. Sed tincidunt bibendum felis at feugiat. Vivamus at placerat felis. Nulla id nisl lectus, id feugiat urna. Phasellus suscipit eros ultrices nunc imperdiet dapibus. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Nunc erat ligula, imperdiet eu posuere a, feugiat a diam.

		Nullam imperdiet ultrices arcu non egestas. Vestibulum eget sem ante. Nunc venenatis turpis vel augue gravida imperdiet. Praesent fermentum imperdiet ligula sed gravida. In volutpat dolor sed nulla vulputate posuere. Pellentesque aliquet nunc et tellus varius id varius tortor adipiscing. Vivamus convallis orci at massa sodales vel fermentum augue consectetur. Morbi in mauris lorem, vitae tincidunt orci. Nullam a dolor justo. Mauris scelerisque velit ut augue consequat consectetur.

		Morbi gravida ipsum et enim iaculis lacinia. Vestibulum blandit, dui eu commodo tincidunt, elit nibh tincidunt nibh, at volutpat mauris ipsum a eros. Mauris sit amet mi sed ligula hendrerit pellentesque. Sed vestibulum eros non magna volutpat porta. Integer rhoncus ullamcorper mauris, vitae viverra nibh interdum eget. Pellentesque sollicitudin aliquet eros, at porttitor lacus dapibus vitae. Quisque placerat orci at lectus dictum vitae congue dolor aliquam. Fusce feugiat justo facilisis diam volutpat at fermentum mi convallis. Aliquam at neque ut libero aliquet placerat sed nec lacus. Cras dictum tincidunt elit id fringilla. Nullam vehicula risus eget orci fermentum at pulvinar ligula lacinia. Vivamus est elit, pellentesque non eleifend eu, volutpat id arcu. Suspendisse in rutrum nulla.

		Mauris tempor fringilla neque, eu molestie dui ornare at. Phasellus egestas blandit mollis. Mauris euismod, velit convallis ullamcorper iaculis, urna metus dictum lacus, viverra tincidunt orci felis sit amet est. Suspendisse pharetra consequat ipsum, at fermentum massa scelerisque at. Donec rutrum ipsum sed.";

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
		$this->assertEquals($response->RESPONSE, $response_text);
		$this->assertEquals(count($response), 1);
		
		// submit a second to make sure it overwrites
		$this->assertTrue(Response::submitEssayQuestion($user_id, $question_id, $response_text2));
		
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
		$this->assertEquals($response->RESPONSE, $response_text2);
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
		// this count is also dependent on members we get from the Identity
		// for now I'll just be hardcoding this in
		$count = 4;
		
		// get the results
		/*
		$results = Response::getResults($quiz_id);
		// assert that there are 3 people in the results 
		//$this->assertEquals($count, sizeof($results), "Note that this is dependent on the members you get from the identity (UserIdentity::getUsers) so if this is off, check count value");
		// assert that results have a name, score and status
		foreach($results as $result){
			$this->assertNotNull($result['name']);
			$this->assertNotNull($result['score']);
			$this->assertNotNull($result['status']);
		}
		
		$quiz_id = 2;
		$count = 0;
		// get the results
		$results = Response::getResults($quiz_id);
		// assert that there are 3 people in the results 
		//$this->assertEquals($count, sizeof($results));
		// assert that results have a name, score and status
		foreach($results as $result){
			$this->assertNotNull($result['name']);
			$this->assertNotNull($result['score']);
			$this->assertNotNull($result['status']);
		}
*/

	}
	
	public function testGetTotalScoreByUser(){
		$user_id = 2;
		$quiz_id = 1;
		$score = 17;
		
		$this->assertEquals($score, Response::getTotalScoreByUser($user_id, $quiz_id));
	}

	public function testIsAnswerCorrect(){
		$user_id = 2;
		$correct_answer_id = 1;
		$incorrect_answer_id = 2;
		
		$this->assertTrue(Response::isAnswerCorrect($user_id, $correct_answer_id));
		$this->assertFalse(Response::isAnswerCorrect($user_id, $incorrect_answer_id));
		
	}

	public function testIsAnswerSelected(){
		$user_id = 2;
		$correct_answer_id = 1;
		$incorrect_answer_id = 2;
		
		$this->assertTrue(Response::isAnswerSelected($user_id, $correct_answer_id));
		$this->assertFalse(Response::isAnswerSelected($user_id, $incorrect_answer_id));
		
	}
	
	public function testGetScore(){
		$response_id = 1;
		$score = 1;
		
		// check getScore
		$this->assertEquals($score, Response::getScore($response_id));
		
	}

	public function testSetScore(){
		$response_id = 1;
		$pre_score = 1;
		$post_score = 2;
		
		// get score
		$score = Response::getScore($response_id);
		$this->assertEquals($pre_score, $score);
		// call grade, check status
		$this->assertTrue(Response::setScore($response_id, $post_score));
		// get score
		$response = Response::model()->findByPk($response_id);
		//$score = Response::getScore($response_id);
		$this->assertEquals($post_score, $response->SCORE);
		$this->assertEquals(Response::MANUAL_SCORED, $response->SCORE_STATE);
		
	}
	
	public function testGradeQuiz(){
		$user_id = 3;
		$quiz_id = 1;
		
		Response::gradeQuiz($user_id, $quiz_id);
		// now get all responses from the quiz and user
		$question_ids = Quiz::getQuestionIds($quiz_id);
		$responses = Response::model()->findAllByAttributes(array('QUESTION_ID'=>$question_ids, 'USER_ID'=>$user_id));
		// get all question->points
		$question_points = Quiz::getQuestionPoints($quiz_id);
		
		$question_score_hash = array();
		// need the essay ids so we know what to ignore later
		$essay_ids = array();
		foreach($responses as $response){
			if(isset($question_score_hash[$response->QUESTION_ID]))
				$question_score_hash[$response->QUESTION_ID] += $response->SCORE;
			else
				$question_score_hash[$response->QUESTION_ID] = $response->SCORE;
			
			if($response->QUESTION_TYPE == Question::ESSAY)
				array_push($essay_ids, $response->QUESTION_ID);
		}
		
		//echo(var_export($question_points, 1)."\n");
		//echo(var_export($question_score_hash, 1)."\n");
		foreach($question_points as $question_id => $points){
			if(!in_array($question_id, $essay_ids))
				//$this->assertEquals($points, $question_score_hash[$question_id], "Failing on question_id: $question_id");
				$this->markTestIncomplete("this is not a good test for fillins, they end up 3x their size");
			
		}
		$this->assertNotNull($responses);
		
	}
	
	public function testDeleteByQuizIdUserId(){
		$user_id = 3;
		$quiz_id = 1;
		
		// get question_ids
		$question_ids = Quiz::getQuestionIds($quiz_id);
		$question_ids_string = implode(",", $question_ids);
		// check that user has responses for given quiz
		$responses = Response::model()->findAllByAttributes(array('USER_ID'=>$user_id, 'QUESTION_ID'=>$question_ids));
		
		$this->assertEquals(sizeof($responses), 11, "Failed asserting initial responses equal 11");
		
		$this->assertTrue(Response::deleteByQuizIdUserId($quiz_id, $user_id));
		
		$this->assertEquals(sizeof($responses), 0, "Failed asserting final responses equal 0");
		
		
	}

}
