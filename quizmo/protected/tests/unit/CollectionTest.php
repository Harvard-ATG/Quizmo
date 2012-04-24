<?php
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


        
    }   
   
}
