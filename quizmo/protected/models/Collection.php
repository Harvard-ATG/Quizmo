<?php

/**
 * Collection
 *
 * This is the model class for table "Collections".
 *
 * The followings are the available columns in table 'Collections':
 * integer $id
 * string $other_id
 * string $title
 * string $description
 * integer $deleted
 *
 * @package app.Model
 */
class Collection extends QActiveRecord
{

	/**
	 * sequenceName
	 *
	 * this is needed by QActiveRecord for Oracle
	 * 
	 * @var string
	 */
	public $sequenceName = 'COLLECTIONS_SEQ';	
	
	/**
	 * created originally by Yii's Gii
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Collection the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * created originally by Yii's Gii
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'COLLECTIONS';
	}

	/**
	 * created originally by Yii's Gii
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('TITLE, DELETED', 'required'),
			array('DELETED', 'numerical', 'integerOnly'=>true),
			array('OTHER_ID, TITLE, DESCRIPTION', 'length', 'max'=>255),
			array('DESCRIPTION', 'length', 'max'=>3900),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, OTHER_ID, TITLE, DESCRIPTION, DELETED', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * created originally by Yii's Gii
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'quizzes' => array(self::HAS_MANY, 'QUIZZES', 'COLLECTION_ID'),
			'userscollections' => array(self::HAS_MANY, 'USERSCOLLECTIONS', 'COLLECTION_ID'),
		);
	}

	/**
	 * created originally by Yii's Gii
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'OTHER_ID' => 'Other',
			'TITLE' => 'Title',
			'DESCRIPTION' => 'Description',
			'DELETED' => 'Deleted',
		);
	}

	/**
	* primaryKey
	* @return integer 
	*/
	public function primaryKey(){
		return 'ID';
	}

	/**
	 * created originally by Yii's Gii
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('ID',$this->ID);
		$criteria->compare('OTHER_ID',$this->OTHER_ID,true);
		$criteria->compare('TITLE',$this->TITLE,true);
		$criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
		$criteria->compare('DELETED',$this->DELETED);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	* create
	* @param string $title
	* @param string $description
	* @param integer $other_id
	* @param boolean $deleted
	* @return integer $collection_id
	*/
	public function create($title, $description, $other_id='', $deleted=0){
		
		if($title == ''){
			return false;
		}
		$this->setAttributes(array(
		        'OTHER_ID'=>$other_id,
		        'TITLE'=>$title,
		        'DESCRIPTION'=>$description,
		        'DELETED'=>$deleted,
				
	    ),false);
		
		$this->save();
		return $this->ID;
	}
	
	/**
	* getByOtherId
	* @param integer $other_id
	* @return object Collection
	*/
	public function getByOtherId($other_id){
		$collection = Collection::model()->find('other_id=:other_id', array(':other_id' => $other_id));
		//$this->find('other_id=:other_id', array(':other_id' => $other_id));
		return $collection;		

	}
	
}