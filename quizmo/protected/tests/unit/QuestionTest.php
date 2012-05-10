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
		$question_type = 'M';
		$title = "Unit Test Title";
		$body = "Unit test body...";
		$score = "10";
		$feedback = "this is feedback";
		$multiple_answers = array(
			array("answer"=>"one", "is_correct"=>1),
			array("answer"=>"two", "is_correct"=>0),
			array("answer"=>"three", "is_correct"=>0),			
		);

		$question = new Question;
		
		$this->assertGreaterThan(0, $question->createMultipleChoice($quiz_id, $question_type, $title, $body, $score, $feedback, $multiple_answers), "Failed asserting that create works with all items");
		
		// now check to make sure the answers were put in		
		$answers = Answer::model()->findAll('question_id=:question_id', array(':question_id' => $question->ID));
		$this->assertEquals(sizeof($multiple_answers), sizeof($answers), "Failed asserting that the appropriate number of answers were added for the question.");
		
		
	}

  	public function testCreateTrueFalse(){
		$quiz_id = 1;
		$title = "Unit Test TF Title";
		$body = "true or false?";
		$score = "10";
		$feedback = "this is feedback";
		$truefalse = true;
		
		$question = new Question;
		
		$this->assertGreaterThan(0, $question->createTrueFalse($quiz_id, $title, $body, $score, $feedback, $truefalse), "Failed asserting that create works with all items");
		
	}



   
}
