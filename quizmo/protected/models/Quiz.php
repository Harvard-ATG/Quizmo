<?php

/**
 * This is the model class for table "Quizes".
 *
 * The followings are the available columns in table 'Quizes':
 * @property integer $id
 * @property integer $collection_id
 * @property string $title
 * @property string $description
 * @property integer $visibility
 * @property string $state
 * @property integer $show_feedback
 * @property string $start_date
 * @property string $end_date
 * @property string $date_modified
 * @property integer $deleted
 */
class Quiz extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Quiz the static model class
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
		return 'QUIZES';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('COLLECTION_ID, TITLE, VISIBILITY, DELETED', 'required'),
			array('COLLECTION_ID, VISIBILITY, SHOW_FEEDBACK, DELETED', 'numerical', 'integerOnly'=>true),
			array('TITLE, DESCRIPTION, STATE', 'length', 'max'=>255),
			array('START_DATE, END_DATE, DATE_MODIFIED', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, COLLECTION_ID, TITLE, DESCRIPTION, VISIBILITY, STATE, SHOW_FEEDBACK, START_DATE, END_DATE, DATE_MODIFIED, DELETED', 'safe', 'on'=>'search'),
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
			'TITLE' => 'Title',
			'DESCRIPTION' => 'Description',
			'VISIBILITY' => 'Visibility',
			'STATE' => 'State',
			'SHOW_FEEDBACK' => 'Show Feedback',
			'START_DATE' => 'Start Date',
			'END_DATE' => 'End Date',
			'DATE_MODIFIED' => 'Date Modified',
			'DELETED' => 'Deleted',
		);
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

		$criteria->compare('ID',$this->id);
		$criteria->compare('COLLECTION_ID',$this->collection_id);
		$criteria->compare('TITLE',$this->title,true);
		$criteria->compare('DESCRIPTION',$this->description,true);
		$criteria->compare('VISIBILITY',$this->visibility);
		$criteria->compare('STATE',$this->state,true);
		$criteria->compare('SHOW_FEEDBACK',$this->show_feedback);
		$criteria->compare('START_DATE',$this->start_date,true);
		$criteria->compare('END_DATE',$this->end_date,true);
		$criteria->compare('DATE_MODIFIED',$this->date_modified,true);
		$criteria->compare('DELETED',$this->deleted);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}