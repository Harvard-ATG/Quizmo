<?php

/**
 * This is the model class for table "Users".
 *
 * The followings are the available columns in table 'Users':
 * @property integer $id
 * @property string $external_id
 * @property string $name
 * @property string $fname
 * @property string $lname
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
}
