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
		
		// setupUsersFromIdentity()
		UsersCollection::setupUsersFromIdentity();
		
		// get all users who have logged into this table
		$userscollections = UsersCollection::model()->findAllByAttributes(array("COLLECTION_ID" => $collection_id));
		
		$users = array();
		foreach($userscollections as $userscollection){
			array_push($users, $userscollection->ID);
		}
		
		return $users;
		
	}
	
	public function setupUsersFromIdentity(){
		// get identity
		$identity = IdentityFactory::getIdentity();
		// call identity getAllUsers method
		//$identity->getAllUsers();
		

		
	}

}
