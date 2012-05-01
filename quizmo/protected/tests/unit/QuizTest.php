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
		$this->assertEquals(3, sizeof($collections));
		
		
	}
   
}
