<?php
/**
 * TestIdentity is an actual "mock" class to deal with identities
 *
 * Just want to have a class for dealing with
 */
class TestIdentity extends UserIdentity {
	
	
	/**
	* TestIdentity Constructor
	*
	* This just takes in 3-4 vars and puts them into the UserIdentity protected vars
	* Then it runs UserIdentity->setup() as all Identities should
	*/
	public function __construct($id, $external_id, $name, $collections=array()){
		$this->id = $id;
		$this->external_id = $external_id;
		$this->name = $name;
		$this->collections = $collections;
		
		$this->setup();		
	}
	

	/**
	* logout() 
	*
	* This just destroys the session, this is where a normal XyzIdentity will log itself out of the service
	*/
	public function logout(){
		@session_destroy();
	}
	
	
}


?>