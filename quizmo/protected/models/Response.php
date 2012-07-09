<?php

/**
 * This is the model class for table "Responses".
 *
 * The followings are the available columns in table 'Responses':
 * @property integer $ID
 * @property integer $QUESTION_ID
 * @property string $QUESTION_TYPE
 * @property integer $USER_ID
 * @property string $RESPONSE
 * @property string $SCORE_STATE
 * @property integer $SCORE
 * @property string $DATE_MODIFIED
 * @property integer $MODIFIED_BY
 */
class Response extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Response the static model class
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
		return 'Responses';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('QUESTION_ID, QUESTION_TYPE, USER_ID', 'required'),
			array('QUESTION_ID, USER_ID, SCORE, MODIFIED_BY', 'numerical', 'integerOnly'=>true),
			array('QUESTION_TYPE, RESPONSE, SCORE_STATE', 'length', 'max'=>255),
			array('DATE_MODIFIED', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, QUESTION_ID, QUESTION_TYPE, USER_ID, RESPONSE, SCORE_STATE, SCORE, DATE_MODIFIED, MODIFIED_BY', 'safe', 'on'=>'search'),
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
			'QUESTION_ID' => 'Question',
			'QUESTION_TYPE' => 'Question Type',
			'USER_ID' => 'User',
			'RESPONSE' => 'Response',
			'SCORE_STATE' => 'Score State',
			'SCORE' => 'Score',
			'DATE_MODIFIED' => 'Date Modified',
			'MODIFIED_BY' => 'Modified By',
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
		$criteria->compare('QUESTION_ID',$this->question_id);
		$criteria->compare('QUESTION_TYPE',$this->question_type,true);
		$criteria->compare('USER_ID',$this->user_id);
		$criteria->compare('RESPONSE',$this->response,true);
		$criteria->compare('SCORE_STATE',$this->score_state,true);
		$criteria->compare('SCORE',$this->score);
		$criteria->compare('DATE_MODIFIED',$this->date_modified,true);
		$criteria->compare('MODIFIED_BY',$this->modified_by);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}