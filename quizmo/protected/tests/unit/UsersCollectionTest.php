<?php
/**
* UsersCollectionTest unit test
*
* 
*/
class UsersCollectionTest extends CDbTestCase {
   

	public $fixtures=array(
		'collections'=>'Collection',
		'users'=>'User',
		'quizes'=>'Quiz',
		'submissions'=>'Submission',
		'questions'=>'Question',
		'responses'=>'Response',
		'answers'=>'Answer',
		'userscollections'=>'UsersCollection',
	);
	
	/**
	* testAddUserToCollection
	*
	* 
	*/
	public function testAddUserToCollection(){
				
		$user_id = 1;
		$collection_id = 1;
		$permission = 'enrollee';
				
		$userscollection = new UsersCollection;
		$userscollection->addUserToCollection($user_id, $collection_id, $permission);
	    $this->assertTrue($userscollection->save(false));
			
		
    }   
	
	
	public function testGetCollectionArrayByUserId(){
		$user_id = 1;
		$collection_idArr = array(1, 2);
		
		$collectionArray = UsersCollection::getCollectionArrayByUserId($user_id);
		$this->assertContains($collectionArray[0]['ID'], $collection_idArr);
		$this->assertContains($collectionArray[1]['ID'], $collection_idArr);

		
	}

   
}
