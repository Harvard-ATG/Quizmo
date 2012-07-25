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
		'answers'=>'Answer',
		'responses'=>'Response',
	);
	


	public function testGetQuestionArrayByQuizId(){
		$quiz_id = 1;
		
		$questions = Question::getQuestionArrayByQuizId($quiz_id);
		// this is based on the fixtures..
		$this->assertEquals(8, sizeof($questions));
		
		
	}



	public function testGetNextQuestionOrder(){
		$quiz_id = 1;
		$number = 9;
		
		$question_order = Question::getNextQuestionOrder($quiz_id);
		// this is based on the fixtures..
		$this->assertEquals($question_order, $number);
		
	}

	public function testCreate(){
		$quiz_id = 1;
		$question_type = 'E';
		$title = "Question::create unit test";
		$body = "Question::create unit test body";
		$score = "1";
		$feedback = "this is feedback";
		$question = new Question;
		$this->assertGreaterThan(0, $question->create($quiz_id, $question_type, $title, $body, $score, $feedback), "Failed asserting that create works with all items");
		
		
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
		$this->assertEquals(sizeof($multiple_answers), sizeof($answers), "Failed asserting that the appropriate number of answers were added for the multiple-choice question.");
		
		
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
		
		$answers = Answer::model()->findAll('question_id=:question_id', array(':question_id' => $question->ID));
		$this->assertEquals(2, sizeof($answers), "Failed asserting that the appropriate number of answers were added for the true/false question.");
		
	}

	public function testCreateEssay(){
		$quiz_id = 1;
		$title = "Unit Test Essay Title";
		$body = "talk about something";
		$score = "10";
		$feedback = "this is feedback";
		$textarea_rows = 20;
		
		$question = new Question;		
		$this->assertGreaterThan(0, $question->createEssay($quiz_id, $title, $body, $score, $feedback, $textarea_rows), "Failed asserting that createEssay works with all items");
		
		$answers = Answer::model()->findAll('question_id=:question_id', array(':question_id' => $question->ID));
		$this->assertEquals(1, sizeof($answers), "Failed asserting that the appropriate number of answers were added for the essay question.");
		
	}
	
	public function testCreateNumerical(){
		$quiz_id = 1;
		$title = "Unit Test Numerical Title";
		$body = "a number!";
		$score = "10";
		$feedback = "this is feedback";
		$tolerance = 20;
		
		$question = new Question;		
		$this->assertGreaterThan(0, $question->createNumerical($quiz_id, $title, $body, $score, $feedback, $tolerance), "Failed asserting that createNumerical works with all items");
		
		$answers = Answer::model()->findAll('question_id=:question_id', array(':question_id' => $question->ID));
		$this->assertEquals(1, sizeof($answers), "Failed asserting that the appropriate number of answers were added for the numerical question.");		

	}

	public function testCreateFillin(){
		$quiz_id = 1;
		$title = "Unit Test Essay Title";
		$body = "roses are {red}, violets are {blue}";
		$score = "10";
		$feedback = "this is feedback";
		$is_case_sensitive = 1;
		
		$question = new Question;		
		$this->assertGreaterThan(0, $question->createFillin($quiz_id, $title, $body, $score, $feedback, $is_case_sensitive), "Failed asserting that createFillin works with all items");
		
		$answers = Answer::model()->findAll('question_id=:question_id', array(':question_id' => $question->ID));
		$this->assertEquals(1, sizeof($answers), "Failed asserting that the appropriate number of answers were added for the Fill in the Blank question.");		

	}

	public function testGetQuestionViewById(){
		$user_id = 2;
		$question_id = 1;
		$question_type = Question::MULTIPLE_CHOICE;
		
		$question =  Question::getQuestionViewById($question_id, $user_id);
		
		// check that the question is the right type
		$this->assertEquals($question_type, $question['question_type']);
		// check that it has an associated answer
		$this->assertNotNull($question['answers'][0]);
		// check that the answer is of the same type
		$this->assertEquals($question['question_type'], $question['answers'][0]['question_type']);
		// check the question has a response associated
		$this->assertNotNull($question['responses']);
		// check the question's first answer is right
		$this->assertTrue($question['answers'][0]['response']);
		
		
	}
	
	public function testGetQuestionViewsByQuizId(){
		$user_id = 2;
		$quiz_id = 1;
		$question_count = 8;
		$question_id = 2;
		$question_type = Question::TRUE_FALSE;
		$score = 1;
		$points = 0;
		
		$questions = Question::getQuestionViewsByQuizId($quiz_id, $user_id);
		// check the number is right
		$this->assertEquals($question_count, count($questions));
		// check the second question id is right 
		$this->assertEquals($question_id, $questions[1]['id']);
		// check the second question type is right
		$this->assertEquals($question_type, $questions[1]['question_type']);
		// check the second question has answers associated
		$this->assertNotNull($questions[1]['answers']);
		// check the second question has a response associated
		$this->assertNotNull($questions[1]['responses']);
		// check the first question, first answer is right
		$this->assertTrue($questions[0]['answers'][0]['response']);
		// check the score
		$this->assertEquals($score, $questions[0]['score']);
		// check the points
		$this->assertEquals($points, $questions[0]['points']);
		
		//$this->markTestIncomplete();

	}
	
	public function testGetTotalScore(){
		$total_score = 35;
		$quiz_id = 1;
		
		$this->assertEquals($total_score, Question::getTotalScore($quiz_id));
		
	}
	
	public function testGetQuizId(){
		$question_id = 1;
		$quiz_id = 1;
		$this->assertEquals($quiz_id, Question::getQuizId($question_id));
	}
   
}
