<?php
/**
* UserIdentityTest PHPUnit test for UserIdentity
*
* 
*/
class UserIdentityTest extends CDbTestCase {
   

	
	/*
	* Sortof a fixture
	*
	* 
	*/
	public $identities = array(
		'user1' => array(
			'userid' => '12345678',
			'name' => 'Leeroy Jenkins',
			'collections' => array(
				'12345' => 'enrollee'
			),
		),
		'user2' => array(
			'userid' => '12341234',
			'name' => 'Justin Timberlake',
		),
	);
	
	/**
	* testing config/main.php
	*
	* This tests to make sure config options aren't in conflict..
	*/
	public function testConfig(){
		// if the authMethod is isites, we need to make sure the behaviors is set appropriately
		if(Yii::app()->params['authMethod'] == 'isites'){
			
			$this->assertTrue(Yii::app()->behaviors['onBeginRequest']['class'] == "application.components.RequireLogin");			

		}
		
	}

	/**
	* testing UserIdentity::setup()
	*
	* This is currently using a "mock" object to imitate an XyzIdentity.  
	* I am only asserting whether or not the user/collections get set in the database.  
	* And I'm only asserting that the objects are found, not really that they're set appropriately?
	*/
	public function testSetup(){
		
		foreach($this->identities as $identity){
			$useridentity = new TestIdentity('', $identity['userid'], $identity['name'], @$identity['collections']);
			
			// check for value in db...
			//$user = User::model()->find('ID=:id', array(':id'=>$this->id));			
			$user = User::model()->find('external_id=:external_id', array(':external_id' => $identity['userid']));
			$user_id = $user->ID;
			
			$this->assertNotNull($user);
			
			if(@$identity['collections'] != null){
				foreach($identity['collections'] as $collection_id => $permission){
					$collection = Collection::model()->find('other_id=:other_id', array(':other_id' => $collection_id));
					$this->assertNotNull($collection);
					
					//echo("check vars... =={$collection->ID}== =={$user->ID}==");
					$userscollection = UsersCollection::model()->find('collection_id=:collection_id AND user_id=:user_id', 
						array(':collection_id' => $collection->ID, ':user_id' => $user_id));
					$this->assertNotNull($userscollection);
					
				}
				
			}
			
						
			
			if(@$identity['collections'] != null){
				foreach($identity['collections'] as $other_id => $permission){

					//$collection = Collection::model()->findByPk($collection_id);
					$collection = Collection::model()->find('other_id=:other_id', array(':other_id' => $other_id));
					$collection_id = $collection->ID;
					
					
					$userscollection = UsersCollection::model()->find('collection_id=:collection_id AND user_id=:user_id', 
						array(':collection_id' => $collection_id, ':user_id' => $user_id));
					$userscollection->delete();
					$userscollection = UsersCollection::model()->find('collection_id=:collection_id AND user_id=:user_id', 
						array(':collection_id' => $collection_id, ':user_id' => $user_id));
					$this->assertNull($userscollection);
					

					$collection->delete();
					$collection = Collection::model()->find('other_id=:other_id', array(':other_id' => $other_id));
					$this->assertNull($collection);
					
					
				}
				
			}

			// now we remove the record and try to find it again
			// note that delete() won't effect the AR, just the data in the database
			$this->assertTrue($user->delete());
			//$user = User::model()->findByPk($identity['id']);
			$user = User::model()->find('external_id=:external_id', array(':external_id' => $identity['userid']));
			
			//$this->assertNull($user);
			

		}


        // Stop here and mark this test as incomplete.
        //$this->markTestIncomplete(
        //  'This test has not been implemented yet.'
        //);
    }   
   
}