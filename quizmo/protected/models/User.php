<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'Users':
 * @property integer $id
 * @property string $external_id
 * @property string $name
 * @property string $fname
 * @property string $lname
 * @property string $email
 */
class User extends QActiveRecord
{

	//public $ID;
	public $sequenceName = 'USERS_SEQ';	

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
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
		return 'USERS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('EXTERNAL_ID, NAME, FNAME, LNAME', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, EXTERNAL_ID, NAME, FNAME, LNAME', 'safe', 'on'=>'search'),
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
			'UsersCollections' => array(self::HAS_MANY, 'User', 'user_id'),
			'Submissions' => array(self::HAS_MANY, 'User', 'user_id'),
			'Responses' => array(self::HAS_MANY, 'User', 'user_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'EXTERNAL_ID' => 'External',
			'NAME' => 'Name',
			'FNAME' => 'Fname',
			'LNAME' => 'Lname',
			'EMAIL' => 'Email',
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
		$criteria->compare('EXTERNAL_ID',$this->EXTERNAL_ID,true);
		$criteria->compare('NAME',$this->NAME,true);
		$criteria->compare('FNAME',$this->FNAME,true);
		$criteria->compare('LNAME',$this->LNAME,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * gets name!  just catting the fname and lname
	 * @param string $id user_id
 	 * @return string name
	 */
	public function getName($id){
		$user = User::model()->findByPk($id);
		return $user->FNAME . " " . $user->LNAME;
		
	}

	/**
	 * gets external_id!
	 * @param string $id user_id
 	 * @return string external_id
	 */
	public function getExternalId($id){
		$user = User::model()->findByPk($id);
		return $user->EXTERNAL_ID;
		
	}
	
	/**
	 * gets the group:
	 * in isites this is enrollee/guest/other
	 * this needs to be implemented elsewhere (isitestool)
	 * @param number $id user_id
	 * @param number $collection_id
	 * @return
	 */
	public function getGroup($id, $collection_id){
		$identity = IdentityFactory::getIdentity();
		return $identity->getGroup($id, $collection_id);
	}


	
	/**
	 * gets name!  just catting the fname and lname
	 * @param string $external_id
	 * @return string name
	 */
	public function getNameByExternal($external_id){
		$user = User::model()->findByAttributes(array('EXTERNAL_ID'=>$external_id));
		return $user->FNAME . " " . $user->LNAME;
		
	}
}
