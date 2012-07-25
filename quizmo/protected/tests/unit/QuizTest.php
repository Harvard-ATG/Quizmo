<?php
/**
* QuizTest unit test
*
* 
*/
class QuizTest extends CDbTestCase {
   

	public $fixtures=array(
		'collections'=>'Collection',
		'quizzes'=>'Quiz',
		'users'=>'User',
		'submissions'=>'Submission',
		'questions'=>'Question',
		'responses'=>'Response',
		'answers'=>'Answer',
		'userscollections'=>'UsersCollection',
		
	);
	

	public function testGetQuizArrayByCollectionId(){
		$user_id = 2;
		$quiz_id = 1;
		$submission_status = Submission::SUBMITTED;
		$collection_id = 1;
				
		$quizzes = Quiz::getQuizArrayByCollectionId($collection_id, $user_id);
		// this is based on the fixtures..
		$this->assertEquals(4, sizeof($quizzes));
		// get user_id 2's submission status
		$this->assertEquals(Submission::SUBMITTED, $quizzes[0]['status']);
		
		
	}
	
	public function testCreate(){
		$collection_id = 1;
		$title = "Unit Test Title";
		$description = "Unit test description...";
		$state = "S";
		// dates need to be implemented
		$start_date = "";
		$end_date = "";
		$visibility = 1;
		$show_feedback = 1;
		$quiz = new Quiz;
		
		$this->assertGreaterThan(0, $quiz->create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback), "Failed asserting that create works with all items");
		$this->assertFalse($quiz->create($collection_id, '', $description, $state, $start_date, $end_date, $visibility, $show_feedback), "Failed asserting that create fails without a title");
		// this fails really hard because of the integrity constraint...
		//$this->assertFalse($quiz->create('', $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback), "Failed asserting that create fails without a collection_id");
		
		$this->markTestIncomplete(
          "This test still needs a correct date format.  It's a timestamp, not sure how to deal with..."
        );
	}
	
	public function testGetQuestionIds(){
		$quiz_id = 1;
		$quiz = new Quiz;
		$this->assertGreaterThan(0, $quiz->getQuestionIds($quiz_id), "Failed asserting that getQuestionIds returns greater than 1 for unit test quiz_id 1.");

	}

	public function testGetQuiz(){
		$quiz_id = 1;
		$title = 'dev quiz prime';
		$collection_id = 1;
		
		$quiz = Quiz::getQuiz($quiz_id);
		$this->assertEquals($title, $quiz->TITLE);
		$this->assertEquals($collection_id, $quiz->COLLECTION_ID);
	}
	
	public function testGetCollectionId(){
		$quiz_id = 1;
		$collection_id = 1;
		
		$this->assertEquals($collection_id, Quiz::getCollectionId($quiz_id));
	}
   
}
