<?php
/**
* UsersCollectionTest unit test
*
* 
*/
class UsersCollectionTest extends CDbTestCase {
   

	
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

   
}
