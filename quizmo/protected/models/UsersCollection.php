<?php

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
}