<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


/**
 * This is the model class for table "USERS_COLLECTIONS".
 *
 * The followings are the available columns in table 'USERS_COLLECTIONS':
 * @property integer $ID
 * @property integer $COLLECTION_ID
 * @property integer $USER_ID
 * @property string $PERMISSION
 *
 * The followings are the available model relations:
 * @property COLLECTIONS $cOLLECTION
 * @property USERS $uSER
 */
class UsersCollection extends QActiveRecord
{
	
	public $sequenceName = 'USERS_COLLECTIONS_SEQ';	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return UsersCollection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'USERS_COLLECTIONS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('COLLECTION_ID, USER_ID', 'required'),
			array('COLLECTION_ID, USER_ID', 'numerical', 'integerOnly'=>true),
			array('PERMISSION', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, COLLECTION_ID, USER_ID, PERMISSION', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'collection' => array(self::BELONGS_TO, 'Collection', 'COLLECTION_ID'),
			'user' => array(self::BELONGS_TO, 'User', 'USER_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'COLLECTION_ID' => 'Collection',
			'USER_ID' => 'User',
			'PERMISSION' => 'Permission',
		);
	}
	
	public function primaryKey(){
		return 'ID';
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('COLLECTION_ID',$this->COLLECTION_ID);
		$criteria->compare('USER_ID',$this->USER_ID);
		$criteria->compare('PERMISSION',$this->PERMISSION,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	* Gets an array of collections with a link
	*/
	public function getCollectionArrayByUserId($user_id){
		$userscollections = UsersCollection::model()->findAll('user_id=:user_id', array(':user_id' => $user_id));
			
		$collectionArray = array();
		foreach($userscollections as $userscollection){
			$collection = $userscollection->collection;
			$collArr = array();
			foreach($collection as $key=>$value){
				$collArr[$key] = $value;
			}
			//$collectionLinks[$collection->ID] = "collection/view/".$collection->ID;
			$collArr['link'] = "/quiz/index/".$collection->ID;
			
			array_push($collectionArray, $collArr);
		}
		
		return $collectionArray;
	}
	
	/**
	 * adds a user to a collection with a given permission
	 * @param number $user_id
	 * @param number $collection_id
	 * @param string $permission
	 * @return number ID
	 */
	public function addUserToCollection($user_id, $collection_id, $permission='enrollee'){
		
		$conditions = 'collection_id=:collection_id AND user_id=:user_id';
		$params = array(':collection_id'=>$collection_id, ':user_id'=>$user_id);
		$this->find($conditions, $params);
		
		$this->setAttributes(array(
		        'USER_ID'=>$user_id,
		        'COLLECTION_ID'=>$collection_id,
		        'PERMISSION'=>$permission,
	    ),false);
		
		$this->save(false);
		
		return $this->ID;
		
	}
	
	/**
	 * gets all users associated with the collection
	 * @param number $collection_id
	 * @return array of user_ids
	 */
	public function getUsers($collection_id){
		//error_log("getUsers");
		
		// setupUsersFromIdentity()
		UsersCollection::setupUsersFromIdentity($collection_id);
		
		// get all users who have logged into this table
		$userscollections = UsersCollection::model()->findAllByAttributes(array("COLLECTION_ID" => $collection_id));
		
		$users = array();
		foreach($userscollections as $userscollection){
			array_push($users, $userscollection->USER_ID);
		}
		
		return $users;
		
	}
	
	/**
	 * gets all users associated with the collection and the associated permissions
	 * @param number $collection_id
	 * @return hash of user_ids as keys and permissions as values {1 => 'enrollee', 2 => 'admin'}
	 */
	public function getUsersAndPermissions($collection_id){
		//error_log("getUsers");
		
		// setupUsersFromIdentity()
		UsersCollection::setupUsersFromIdentity($collection_id);
		
		// get all users who have logged into this table
		$userscollections = UsersCollection::model()->findAllByAttributes(array("COLLECTION_ID" => $collection_id));
		
		$users = array();
		foreach($userscollections as $userscollection){
			$users[$userscollection->USER_ID] = $userscollection->PERMISSION;
		}
		
		return $users;
		
	}
	
	public function setupUsersFromIdentity($collection_id){
		//error_log("setupUsersFromIdentity");
		
		// get identity
		$identity = IdentityFactory::getIdentity();
		// call identity getAllUsers method
		$users = $identity->getAllUsers();
		
		
		// cleanup enrollees
		// only do this if getAllUsers actually got something -- only staff should be able to get a class list
		if(sizeof($users) > 0){
			$criteria = new CDbCriteria;
			$criteria->addCondition("COLLECTION_ID=:collection_id");
			$criteria->addCondition("PERMISSION=:perm_id");
			$criteria->params = array(':collection_id'=>$collection_id, ':perm_id'=>'enrollee');
			$current_enrollees = UsersCollection::model()->with('user')->resetScope()->findAll($criteria);
		
			foreach($current_enrollees as $current_enrollee){
				// make sure the current enrollee is in the current class list
				$found = false;
				foreach($users as $user){
					if($user['id'] == $current_enrollee->user->EXTERNAL_ID){
						$found = true;
					}
				}
				if(!$found){
					// if it's not found, delete this enrollee from the UsersCollection 
					// so they're no longer associated with the course
					UsersCollection::model()->deleteAllByAttributes(array('ID'=>$current_enrollee->ID));
				}
			}
		}
		
		// run through them and add them to the db if they don't already exist, update permission level if they do
		foreach($users as $user){
			// get user with external_id
			$userObj = User::model()->findByAttributes(array('EXTERNAL_ID'=>$user['id']));
			if($userObj == null){
				// create the user
				$userObj = new User;
				$userObj->EXTERNAL_ID = $user['id'];
				$userObj->NAME = $user['firstName']." ".$user['lastName'];
				$userObj->FNAME = $user['firstName'];
				$userObj->LNAME = $user['lastName'];
				$userObj->save();
				
				// create the userscollection
				$usersCollection = new UsersCollection;
				$usersCollection->USER_ID = $userObj->ID;
				$usersCollection->COLLECTION_ID = $collection_id;
				$usersCollection->PERMISSION = $user['group_string'];
				$usersCollection->save();
				
			} else {
				// check the userscollection entry for this collection
				$usersCollection = UsersCollection::model()->findByAttributes(array('USER_ID'=>$userObj->ID, 'COLLECTION_ID'=>$collection_id));
				if($usersCollection != null){
					// update uC if permission is different
					if($usersCollection->PERMISSION != $user['group_string']){
						$usersCollection->PERMISSION = $user['group_string'];
						$usersCollection->save();
					}
				} else {
					// create uC
					$usersCollection = new UsersCollection;
					$usersCollection->USER_ID = $userObj->ID;
					$usersCollection->COLLECTION_ID = $collection_id;
					$usersCollection->PERMISSION = $user['group_string'];
					$usersCollection->save();
				}
			}	
		}		
	}
	
	/**
	 * gets the permission string for the user/collection pair
	 * @param number $user_id
	 * @param number $collection_id
	 * @return string $permission
	 */
	public function getPermissionString($user_id, $collection_id){
		$usersCollection = UsersCollection::model()->findByAttributes(array('USER_ID'=>$user_id, 'COLLECTION_ID'=>$collection_id));
		return $usersCollecion->PERMISSION;
	}

}
