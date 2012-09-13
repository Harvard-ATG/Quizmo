<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

/**
* 
*
* 
*/
class CollectionTest extends CDbTestCase {
   

	
	public $fixtures=array(
		'collections'=>'Collection'
	);

	/**
	* CollectionTest unit test
	*
	* 
	*/
	public function testModel(){
		/*		
		foreach($this->collections as $collectionFixture){
			$collection = new Collection;
			$collection->setAttributes(array(
			        'OTHER_ID'=>$collectionFixture['OTHER_ID'],
			        'TITLE'=>$collectionFixture['TITLE'],
			        'DESCRIPTION'=>$collectionFixture['DESCRIPTION'],
			        'DELETED'=>$collectionFixture['DELETED'],
					
		    ),false);
		    $this->assertTrue($collection->save(false));
			$c_id = $collection->ID;
			
			$this->assertTrue($collection->delete());
			$collection = Collection::model()->findByPk($c_id);
			//$this->assertNull($collection);
				
		}
		*/
		
    }   

	public function testCreate(){
		$title = "Unit Test Title";
		$description = "Unit test description...";
		$collection = new Collection;
		
		$this->assertGreaterThan(0, $collection->create($title, $description), "Failed asserting that create works with a title and description");
		$this->assertGreaterThan(0, $collection->create($title, ''), "Failed asserting that create works with a title and no description");
		$this->assertFalse($collection->create('', ''), "Failed asserting that empty title and description fail to create a new collection");		
		
		
	}
	
	public function testGetByOtherId(){
		foreach($this->collections as $collectionFixture){
			$collection = Collection::getByOtherId($collectionFixture['OTHER_ID']);	
			
			$this->assertEquals($collectionFixture['ID'], $collection->ID, "Failed asserting that getIdFromOtherId is getting the appropriate ID");
			
		}
		
	
	}
	
	
   
}
