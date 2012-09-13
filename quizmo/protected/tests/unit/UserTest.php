<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

/**
* UserIdentityTest PHPUnit test for UserIdentity
*
* 		'NAME' => 'Constantine O\'Hara',
*		'EXTERNAL_ID' => '12345678',
*		'FNAME' => 'Constantine',
*		'LNAME' => 'O\'Hara',
*/
class UserTest extends CDbTestCase {
   

	
	public $fixtures=array(
		'users'=>'User',
	);

	/**
	* UserTest unit test
	*
	* 
	*/
	public function testUser(){
				
		foreach($this->users as $userFixture){
			$user = new User;
			$user->setAttributes(array(
			        'NAME'=>$userFixture['NAME'],
			        'EXTERNAL_ID'=>$userFixture['EXTERNAL_ID'],
			        'FNAME'=>$userFixture['FNAME'],
			        'LNAME'=>$userFixture['LNAME'],
					
		    ),false);
		    $this->assertTrue($user->save(false), "Failed to save.");
			$u_id = $user->ID;
			$this->assertNotNull($user->ID, "Failed asserting that the last insert id was retrieved for this->ID.");
			
			$this->assertTrue($user->delete(), "Failed to delete.");
			$user = Collection::model()->findByPk($u_id);
			//$this->assertNull($collection);
			
			
		}

    }

	/**
	 * testing getName
	 */
	public function testGetName(){
		
		$id = 1;
		$name = $this->users['user1']['FNAME'] . " " . $this->users['user1']['LNAME'];

		$this->assertEquals($name, User::getName($id));		
	}

	/**
	 * testing getNameByExternal
	 */
	public function testGetNameByExternal(){
		
		$external_id = $this->users['user1']['EXTERNAL_ID'];
		$name = $this->users['user1']['FNAME'] . " " . $this->users['user1']['LNAME'];

		$this->assertEquals($name, User::getNameByExternal($external_id));		
	}
}
