<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{

	const SUPER = 9;
	const OWNER = 7;
	const ADMIN = 5;
	const ENROLLEE = 3;
	const GUEST = 1;
	
	const SUPER_STRING = "super";
	const OWNER_STRING = "owner";
	const ADMIN_STRING = "admin";
	const ENROLLEE_STRING = "enrollee";
	const GUEST_STRING = "guest";
	

	public $id;
	protected $external_id;
	public $name;
	public $fname;
	public $lname;
	public $email;
	// this is a hash of collections and permissions
	protected $collections;
	public $perm;
	public $perm_id;
	
	/**
	 * Overriding constructor to help with testing
	 */
	public function __construct($id='', $userid='', $name='') {
		error_log("UserIdentity::construct");
		$this->username = $id;
		//$this->id = $id;
		$this->userid = $userid;
		$this->name = $name;
	}
	

	/**
	 * Authenticates a user.
	 * The example implementation makes sure if the username and password
	 * are both 'demo'.
	 * In practical applications, this should be changed to authenticate
	 * against some persistent user identity storage (e.g. database).
	 * @return boolean whether authentication succeeds.
	 */
	public function authenticate()
	{

		$this->errorCode=self::ERROR_NONE;
		
		return !$this->errorCode;
		
	}
	
	/**
	* UserIdentity::setup
	*
	* we check / update the database here.  
	*
	*/
	protected function setup(){
		
		//error_log("UserIdentity::setup");
		
		// if username is set, then we are logged in
		if($this->external_id){
			
			// find an existing user with that id
			//$user = User::model()->findByPk($this->id);
			//$user = User::model()->find('ID=:id', array(':id'=>$this->id));			
			$user = User::model()->find('external_id=:external_id', array(':external_id' => $this->external_id));

			if($user == null){
				// create new user
				$user = new User;
				
				// NOTE: if you are doing auto-increment, this->ID will be overwritten with whatever
				//    the sequence is at at the save()
				//$user->ID = null;
				$user->EXTERNAL_ID = $this->external_id;
			}

			// first we take the values that were set in the XyzIdentity
			if($this->name){
				// set it in the database
				$user->NAME = $this->name;
			}
			if($this->fname){
				// set it in the database
				$user->FNAME = $this->fname;
			}
			if($this->lname){
				// set it in the database
				$user->LNAME = $this->lname;
			}
			if($this->email){
				// set it in the database
				$user->EMAIL = $this->email;
			}
			
			
			$transaction = $user->dbConnection->beginTransaction();
			
			$user->save();
			$transaction->commit();
			$this->id = $user->ID;
			
			
			if($this->collections){
				//Here is an example of what must be done if you want to reuse an active record instance to insert multiple but similar items:
				//$model->save(false);
				//$model->isNewRecord = true;
				//$model->primaryKey = NULL;
				//$model->someAttribute = 'new value';
				//$model->save(false);
				//The second save will insert a new record.
				
				foreach($this->collections as $other_id => $permission){

					// find an existing collection with that id
					$collection = Collection::model()->find('other_id=:other_id', array(':other_id' => $other_id));
					
					if($collection == null){
						// create a new collection
						$collection = new Collection;
						$collection->OTHER_ID = $other_id;
					}
					// I'm not sure how to name the collection yet...
					// TODO: change this so the title comes from the isites search service...
					$collection->TITLE = $other_id;
					$collection->DELETED = 0;
					$collection->save();
					
					// now check for the mtm entry
					$conditions = 'collection_id=:collection_id AND user_id=:user_id';
					$params = array(':collection_id'=>$collection->ID, ':user_id'=>$user->ID);
					$userscollection = UsersCollection::model()->find($conditions, $params);
					
					if($userscollection == null){
						// create a new userscollection
						$userscollection = new UsersCollection;
						$userscollection->COLLECTION_ID = $collection->ID;
						$userscollection->USER_ID = $user->ID;
						
					}
					
					// then set permissions in the db
					$userscollection->PERMISSION = $permission;
					$userscollection->save();
					
				}
			}
			
			//$user->save();
			
			
		}


		
	}
	
	/**
	 * placeholder method -- this should be overridden by the XIdentity if it has a way
	 * @return boolean always returns true
	 */
	public function getAllUsers(){
		return true;
	}
	
	/**
	 * placeholder method -- this should be overridden by the XIdentity if it has a way
	 * @return string always returns ''
	 */
	public function getGroup(){
		return '';
	}
	
	/**
	 * placeholder method -- this should be overridden by the XIdentity if it has a way
	 * @return string if there is no
	 */
	public function getPhotoUrl($id=null, $size=128){
		return "http://".$_SERVER['HTTP_HOST']."/img/user-icon.png";
	}
	
}
