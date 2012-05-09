<?php
/**
* QuizTest unit test
*
* 
*/
class QuestionTest extends CDbTestCase {
   

	public $fixtures=array(
		'quizes'=>'Quiz',
		'questions'=>'Question',
	);
	


	public function testGetQuestionArrayByQuizId(){
		$quiz_id = 1;
		
		$questions = Question::getQuestionArrayByQuizId($quiz_id);
		// this is based on the fixtures..
		$this->assertEquals(5, sizeof($questions));
		
		
	}



	public function testGetNextQuestionOrder(){
		$quiz_id = 1;
		$number = 6;
		
		$question_order = Question::getNextQuestionOrder($quiz_id);
		// this is based on the fixtures..
		$this->assertEquals($question_order, $number);
		
	}
	

	//	public function createMultipleChoice($quiz_id, $title, $body, $score, $feedback, $multiple_radio_answer, $multiple_answers){

	public function testCreateMultipleChoice(){
		$quiz_id = 1;
		$title = "Unit Test Title";
		$body = "Unit test body...";
		$score = "10";
		$feedback = "this is feedback";
		$multiple_radio_answer = 0;
		$multiple_answers = array(
			array("answer"=>"one", "is_correct"=>1),
			array("answer"=>"two", "is_correct"=>0),
			array("answer"=>"three", "is_correct"=>0),			
		);

		$question = new Question;
		
		$this->assertGreaterThan(0, $question->createMultipleChoice($quiz_id, $title, $body, $score, $feedback, $multiple_radio_answer, $multiple_answers), "Failed asserting that create works with all items");

	}

   
   
}
