<?php

/**
 * Answer
 *
 * This is the model class for table "Answers".
 *
 * The followings are the available columns in table 'Answers':<br>
 * integer $id <br>
 * integer $question_id <br>
 * string $question_type <br>
 * integer $textarea_rows <br>
 * string $answer <br>
 * integer $is_case_sensitive <br>
 * integer $answer_order <br>
 * integer $is_correct <br>
 * double $tolerance <br>
 *
 * @package app.Model
 */
class Answer extends QActiveRecord
{

	/**
	 * sequenceName
	 *
	 * this is needed by QActiveRecord for Oracle
	 * 
	 * @var string
	 */
	public $sequenceName = 'ANSWERS_SEQ';	

	/**
	 * model
	 *
	 * Returns the static model of the specified AR class.
	 * created originally by Yii's Gii
	 * 
	 * @param string $className active record class name.
	 * @return Answer the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * tableName
	 *
	 * created originally by Yii's Gii
	 *
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ANSWERS';
	}

	/**
	 * rules
	 *
	 * created originally by Yii's Gii
	 *
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('QUESTION_ID, QUESTION_TYPE, IS_CORRECT', 'required'),
			array('QUESTION_ID, TEXTAREA_ROWS, IS_CASE_SENSITIVE, ANSWER_ORDER, IS_CORRECT', 'numerical', 'integerOnly'=>true),
			array('TOLERANCE', 'numerical'),
			array('QUESTION_TYPE, ANSWER', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, QUESTION_ID, QUESTION_TYPE, TEXTAREA_ROWS, ANSWER, IS_CASE_SENSITIVE, ANSWER_ORDER, IS_CORRECT, TOLERANCE', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * relations
	 *
	 * created originally by Yii's Gii
	 *
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'question' => array(self::BELONGS_TO, 'Question', 'QUESTION_ID'),
		);
	}

	/**
	 * attributeLabels
	 *
	 * created originally by Yii's Gii
	 *
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'QUESTION_ID' => 'Question',
			'QUESTION_TYPE' => 'Question Type',
			'TEXTAREA_ROWS' => 'Textarea Rows',
			'ANSWER' => 'Answer',
			'IS_CASE_SENSITIVE' => 'Is Case Sensitive',
			'ANSWER_ORDER' => 'Answer Order',
			'IS_CORRECT' => 'Is Correct',
			'TOLERANCE' => 'Tolerance',
		);
	}

	/**
	 * search
	 *
	 * created originally by Yii's Gii
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
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
		$criteria->compare('TEXTAREA_ROWS',$this->textarea_rows);
		$criteria->compare('ANSWER',$this->answer,true);
		$criteria->compare('IS_CASE_SENSITIVE',$this->is_case_sensitive);
		$criteria->compare('ANSWER_ORDER',$this->answer_order);
		$criteria->compare('IS_CORRECT',$this->is_correct);
		$criteria->compare('TOLERANCE',$this->tolerance);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	


	/**
	* getNextAnswerOrder
	*
	* originally thinking of this just to be used internally
	* when adding new questions -- to get the appropriate question_order
	*
	* @param integer $question_id 
	*
	* @return integer $answer_order
	*/
	public function getNextAnswerOrder($question_id){

		$criteria=new CDbCriteria;
		$criteria->condition = 'question_id='.$question_id;
		$criteria->order = "answer_order DESC";
		
		$answer = Answer::model()->find($criteria);
		if(isset($answer->ANSWER_ORDER))
			return $answer->ANSWER_ORDER+1;
		else
			return 1;

	}
	
	/**
	* create
	*
	* This is probably called from Question::createMultipleChoice
	*
	* @param integer $question_id
	* @param string $question_type 'M', 'T', 'S', 'E', 'F', 'N'
	* @param string $answer
	* @param boolean $is_correct (1, 0)
	* @param integer $textarea_rows
	* @param boolean $is_case_sensitive
	* @param float $tolerance
	*
	* @return integer
	*/
	public function create($question_id, $question_type, $answer, $is_correct, $textarea_rows=10, $is_case_sensitive=0, $tolerance=0){
		
		$answer_order = $this->getNextAnswerOrder($question_id);
		
		$this->setAttributes(array(
	        	'QUESTION_ID'=>$question_id,
				'QUESTION_TYPE'=>$question_type,
	        	'ANSWER'=>$answer,
				'ANSWER_ORDER'=>$answer_order,
		        'IS_CORRECT'=>$is_correct,	
				'TEXTAREA_ROWS'=>$textarea_rows,
				'IS_CASE_SENSITIVE'=>$is_case_sensitive,
				'TOLERANCE'=>$tolerance,
	    ),false);
		
		$this->save(false);
	
		return $this->ID;
	
	}


	
	
}