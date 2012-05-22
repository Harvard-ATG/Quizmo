<?php
/**
* AnswerTest unit test
*
* 
*/
class AnswerTest extends CDbTestCase {
   

	public $fixtures=array(
		'answers'=>'Answer',
	);
	

	public function testGetNextAnswerOrder(){
		$question_id = 1;
		$number = 4;
		
		$answer_order = Answer::getNextAnswerOrder($question_id);
		// this is based on the fixtures..
		$this->assertEquals($answer_order, $number);
		
	}
	



//	public function createMultipleChoiceAnswer($question_id, $answer, $is_correct){
	public function testCreate(){
		$question_id = 1;
		$question_type = 'M';
		$answer_txt = "Unit Test Answer";
		$is_correct = 1;

		$answer = new Answer;
		
		$this->assertGreaterThan(0, $answer->create($question_id, $question_type, $answer_txt, $is_correct), "Failed asserting that create works with all items");

		
	}
   
   
}
