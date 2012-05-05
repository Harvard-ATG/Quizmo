<?php

/**
 * This is the model class for table "Collections".
 *
 * The followings are the available columns in table 'Collections':
 * @property integer $id
 * @property string $other_id
 * @property string $title
 * @property string $description
 * @property integer $deleted
 */
class Collection extends QActiveRecord
{

	//public $ID;
	public $sequenceName = 'COLLECTIONS_SEQ';	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Collection the static model class
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
		return 'COLLECTIONS';
	}

	/**
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
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, OTHER_ID, TITLE, DESCRIPTION, DELETED', 'safe', 'on'=>'search'),
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
			'quizes' => array(self::HAS_MANY, 'QUIZES', 'COLLECTION_ID'),
			'userscollections' => array(self::HAS_MANY, 'USERSCOLLECTIONS', 'COLLECTION_ID'),
		);
	}

	/**
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
		$criteria->compare('OTHER_ID',$this->OTHER_ID,true);
		$criteria->compare('TITLE',$this->TITLE,true);
		$criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
		$criteria->compare('DELETED',$this->DELETED);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
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
	
	public function getByOtherId($other_id){
		$collection = Collection::model()->find('other_id=:other_id', array(':other_id' => $other_id));
		//$this->find('other_id=:other_id', array(':other_id' => $other_id));
		return $collection;		

	}
	
}