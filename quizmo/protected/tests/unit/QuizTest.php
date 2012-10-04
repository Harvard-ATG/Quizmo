<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

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
	
	public function testGetNextQuizOrder(){
		$collection_id = 1;
		$number = 5;
		
		$quiz_order = Quiz::getNextQuizOrder($collection_id);
		// this is based on the fixtures..
		$this->assertEquals($quiz_order, $number);
		
	}

	public function testGetQuizArrayByCollectionId(){
		date_default_timezone_set('America/New_York');
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
		// this with the default nls_date_format
		//$start_date = "19-Jan-12";
		//$end_date = "21-Dec-12";
		//$start_date = "01/19/2012";
		//$end_date = "12/21/2012";
		$start_date = "2012-01-19";
		$end_date = "2012-12-21";
		$visibility = 1;
		$show_feedback = 1;
		$quiz = new Quiz;
		
		$this->assertGreaterThan(0, $quiz->create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback), "Failed asserting that create works with all items");
		// save this quiz_id for later
		$quiz_id = $quiz->ID;
		
		$this->assertFalse($quiz->create($collection_id, '', $description, $state, $start_date, $end_date, $visibility, $show_feedback), "Failed asserting that create fails without a title");
		// this fails really hard because of the integrity constraint...
		//$this->assertFalse($quiz->create('', $title, $description, $state, $start_date, $end_date, $visibility, $show_feedback), "Failed asserting that create fails without a collection_id");
		
		$quiz = Quiz::model()->findByPk($quiz_id);
		// check state
		$this->assertEquals($title, $quiz->TITLE);
		$this->assertEquals($description, $quiz->DESCRIPTION);
		$this->assertEquals($state, $quiz->STATE);
		$this->assertEquals($start_date, substr($quiz->START_DATE, 0, 10));
		$this->assertEquals($end_date, substr($quiz->END_DATE, 0, 10));
		$this->assertEquals($visibility, $quiz->VISIBILITY);
		$this->assertEquals($show_feedback, $quiz->SHOW_FEEDBACK);
		
		
		//$this->markTestIncomplete(
        //  "This test still needs a correct date format.  It's a timestamp, not sure how to deal with..."
        //);
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
	
	public function testSetDeleted(){
		$quiz_id = 2;
		$this->assertTrue(Quiz::setDeleted($quiz_id));
		// check that it's actually deleted
		// resetScope takes away default scope
		$this->assertEquals(1, Quiz::model()->resetScope()->findByPk($quiz_id)->DELETED);
		
	}
	
	public function testGetQuestionPoints(){
		$quiz_id = 1;
		$test_hash = Quiz::getQuestionPoints($quiz_id);
		foreach($this->questions as $question){
			if($question['QUIZ_ID'] == $quiz_id){
				$this->assertEquals($question['POINTS'], $test_hash[$question['ID']]);
				unset($test_hash[$question['ID']]);
			}
		}
		
		$this->assertEquals(0, count($test_hash));
		
	}
	
	public function testIsClosedByState(){
		date_default_timezone_set('America/New_York');
		$collection_id = 1;
		$title = "something";
		$state = Quiz::SCHEDULED;
		$nextWeek = date("Y-m-d", time() + (7 * 24 * 60 * 60));
		$nextWeek2 = date("Y-m-d", time() + 2 * (7 * 24 * 60 * 60));
		
		$lastWeek = date("Y-m-d", time() - (7 * 24 * 60 * 60));
		$lastWeek2 = date("Y-m-d", time() - 2 * (7 * 24 * 60 * 60));
		$now = date("Y-m-d");
		
		// create some quizzes based on now()
		// in between 2 weeks should be false
		$quizMiddle = new Quiz;
		$this->assertGreaterThan(0, $quizMiddle->create($collection_id, $title, '', $state, $lastWeek, $nextWeek));
		$this->assertFalse(Quiz::isClosedByState($quizMiddle->STATE, $quizMiddle->START_DATE, $quizMiddle->END_DATE));

		// 2 weeks ago should be true
		$quizPast = new Quiz;
		$this->assertGreaterThan(0, $quizPast->create($collection_id, $title, '', $state, $lastWeek, $lastWeek2));
		$this->assertTrue(Quiz::isClosedByState($quizPast->STATE, $quizPast->START_DATE, $quizPast->END_DATE));
		
		// 2 weeks in the future should be true
		$quizFuture = new Quiz;
		$this->assertGreaterThan(0, $quizFuture->create($collection_id, $title, '', $state, $nextWeek, $nextWeek2));
		$this->assertTrue(Quiz::isClosedByState($quizFuture->STATE, $quizFuture->START_DATE, $quizFuture->END_DATE));		

	}
	
	public function testScheduleState(){
		date_default_timezone_set('America/New_York');
		$collection_id = 1;
		$title = "something";
		$state = Quiz::SCHEDULED;
		$nextWeek = date("Y-m-d", time() + (7 * 24 * 60 * 60));
		$nextWeek2 = date("Y-m-d", time() + 2 * (7 * 24 * 60 * 60));
		
		$lastWeek = date("Y-m-d", time() - (7 * 24 * 60 * 60));
		$lastWeek2 = date("Y-m-d", time() - 2 * (7 * 24 * 60 * 60));
		$now = date("Y-m-d");
		
		// create some quizzes based on now()
		// in between 2 weeks should be false
		$quizMiddle = new Quiz;
		$this->assertGreaterThan(0, $quizMiddle->create($collection_id, $title, '', $state, $lastWeek, $nextWeek));
		$this->assertEquals(Quiz::SCHEDULED_STARTED, Quiz::scheduleState($quizMiddle->START_DATE, $quizMiddle->END_DATE));

		// 2 weeks ago should be true
		$quizPast = new Quiz;
		$this->assertGreaterThan(0, $quizPast->create($collection_id, $title, '', $state, $lastWeek, $lastWeek2));
		$this->assertEquals(Quiz::SCHEDULED_ENDED, Quiz::scheduleState($quizPast->START_DATE, $quizPast->END_DATE));
		
		// 2 weeks in the future should be true
		$quizFuture = new Quiz;
		$this->assertGreaterThan(0, $quizFuture->create($collection_id, $title, '', $state, $nextWeek, $nextWeek2));
		$this->assertEquals(Quiz::SCHEDULED_NOT_STARTED, Quiz::scheduleState($quizFuture->START_DATE, $quizFuture->END_DATE));
		
	}
   
	public function testScheduleTimeTill(){
		date_default_timezone_set('America/New_York');
		$collection_id = 1;
		$title = "something";
		$state = Quiz::SCHEDULED;
		$nextWeek = date("Y-m-d", time() + (7 * 24 * 60 * 60));
		$nextWeek2 = date("Y-m-d", time() + 2 * (7 * 24 * 60 * 60));
		
		$lastWeek = date("Y-m-d", time() - (7 * 24 * 60 * 60));
		$lastWeek2 = date("Y-m-d", time() - 2 * (7 * 24 * 60 * 60));
		$now = date("Y-m-d");
		
		// create some quizzes based on now()
		// in between 2 weeks should be false
		$quizMiddle = new Quiz;
		$this->assertGreaterThan(0, $quizMiddle->create($collection_id, $title, '', $state, $lastWeek, $nextWeek));
		$this->assertEquals(6, Quiz::scheduleTimeTill($quizMiddle->START_DATE, $quizMiddle->END_DATE));

		// 2 weeks ago should be true
		$quizPast = new Quiz;
		$this->assertGreaterThan(0, $quizPast->create($collection_id, $title, '', $state, $lastWeek2, $lastWeek));
		$this->assertEquals(7, Quiz::scheduleTimeTill($quizPast->START_DATE, $quizPast->END_DATE));
		
		// 2 weeks in the future should be true
		$quizFuture = new Quiz;
		$this->assertGreaterThan(0, $quizFuture->create($collection_id, $title, '', $state, $nextWeek, $nextWeek2));
		$this->assertEquals(6, Quiz::scheduleTimeTill($quizFuture->START_DATE, $quizFuture->END_DATE));
		
	}
	
	public function testReset(){
		$quiz_id = 1;
		// check that it has responses
		$this->assertGreaterThan(0, sizeof(Response::getResults($quiz_id)));
		// reset
		$this->assertTrue(Quiz::reset($quiz_id));
		// check that it has no responses
		//$this->assertEquals(6, sizeof(Response::getResults($quiz_id)), "note that 6 should be 0 if the Identity::getUsers is implemented");
		
	}
	
	public function testReorder(){
		$tests = array(
			array(
				'quiz_id' => 1,
				'from' => 1,
				'to' => 2,
				'expected_order' => array(2, 1, 3, 4),
			),
			array(
				'quiz_id' => 1,
				'from' => 2,
				'to' => 1,
				'expected_order' => array(1, 2, 3, 4),
			),
			array(
				'quiz_id' => 2,
				'from' => 2,
				'to' => 4,
				'expected_order' => array(1, 3, 4, 2),
			),
			array(
				'quiz_id' => 2,
				'from' => 4,
				'to' => 2,
				'expected_order' => array(1, 2, 3, 4),
			),
			array(
				'quiz_id' => 4,
				'from' => 4,
				'to' => 2,
				'expected_order' => array(1, 4, 2, 3),
			),
		);
		
		foreach($tests as $key => $test){
			$collection_id = Quiz::getCollectionId($test['quiz_id']);
		
		
			// reorder them
			Quiz::reorder($test['quiz_id'], $test['from'], $test['to']);
			// get all quizzes from this collection
			$quizzes = Quiz::model()->findAllByAttributes(array('COLLECTION_ID'=>$collection_id));
		
			// check each sort order
			$count = 0;
			foreach($quizzes as $quiz){
				//echo("test foreach: ".$expected_order[$count].", ".$quiz->ID."\n");
				// check that the ids are correct
				$this->assertEquals($test['expected_order'][$count], $quiz->ID, "failed checking ids on test[$key]");
				$count++;
				// check that the sort order is correct
				$this->assertEquals($count, $quiz->SORT_ORDER, "failed checking sort_orders on test[$key]");
			
			}
		
		}
		
	}
	
	public function testCopy(){
		$quiz_id = 1;
		$expected_id = 7;
		$expected_number_of_questions = 8;
		$question_id = 9;
		$expected_number_of_answers = 3;
		
		// copy it
		Quiz::copy($quiz_id);
		
		// get expected quiz
		$last_quiz = Quiz::model()->findByPk($expected_id);
		$this->assertNotNull($last_quiz);
		$this->assertContains(" (copy)", $last_quiz->TITLE);
	
		// check that it contains the right number of questions
		$question_ids = Quiz::getQuestionIds($last_quiz->ID);
		$this->assertEquals($expected_number_of_questions, sizeof($question_ids));
		
		// check that we have the right number of answers for the first question
		$answers = Answer::model()->findAllByAttributes(array('QUESTION_ID'=>$question_id));
		$this->assertEquals($expected_number_of_answers, sizeof($answers));
		
	}
	
	public function testExportArray(){
		$quiz_id = 1;
		$resultArray = Quiz::exportArray($quiz_id);
		$this->assertEquals(7, sizeof($resultArray));
		$this->assertEquals(19, sizeof($resultArray[4]));

	}

	/**
	 * using php's str_getcsv
	 * http://php.net/manual/en/function.str-getcsv.php
	 * to confirm the correct number of lines in the csv?
	 * no, that doesn't work...
	 * not sure how to test this yet
	 */
	public function testExportCSV(){
		$quiz_id = 1;
		$resultCSV = Quiz::exportCSV($quiz_id);
		$this->markTestIncomplete("I'm not sure how to test Quiz::exportCSV yet...");
		
		//echo($resultCSV);
	}
	

}
