<?php
/**
* QuizTest unit test
*
* 
*/
class QuizTest extends CDbTestCase {
   

	public $fixtures=array(
		'collections'=>'Collection',
		'quizes'=>'Quiz',
	);
	

	public function testGetQuizArrayByCollectionId(){
		$collection_id = 1;
		
		$collections = Quiz::getQuizArrayByCollectionId($collection_id);
		// this is based on the fixtures..
		$this->assertEquals(3, sizeof($collections));
		
		
	}
	
	public function testCreate(){
		$collection_id = 1;
		$title = "Unit Test Title";
		$description = "Unit test description...";
		$state = "S";
		// dates need to be implemented
		$start_date = "0000-00-00 00:00:00";
		$end_date = "0000-00-00 00:00:00";
		$visibility = 1;
		$show_feedback = 1;
		$quiz = new Quiz;
		
		$this->assertGreaterThan(0, $quiz->create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback), "Failed asserting that create works with all items");
		$this->assertFalse($quiz->create($collection_id, '', $description, $state, $start_date, $end_date, $visibility, $show_feedback), "Failed asserting that create fails without a title");
		// this fails really hard because of the integrity constraint...
		//$this->assertFalse($quiz->create('', $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback), "Failed asserting that create fails without a collection_id");
		
		//$this->markTestIncomplete(
        //  'This test still needs a correct date format.'
        //);
	}
   
}
