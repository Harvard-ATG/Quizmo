<?php

/**
 * This is the model class for table "Answers".
 *
 * The followings are the available columns in table 'Answers':
 * @property integer $id
 * @property integer $question_id
 * @property string $question_type
 * @property integer $textarea_rows
 * @property string $answer
 * @property integer $is_case_sensitive
 * @property integer $answer_order
 * @property integer $is_correct
 * @property double $tolerance
 */
class Answer extends QActiveRecord
{

	public $sequenceName = 'ANSWERS_SEQ';	

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Answer the static model class
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
		return 'ANSWERS';
	}

	/**
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
	* @param $question_id int
	*
	* @return $answer_order int
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
	* createMultipleChoiceAnswer
	*
	* This is probably called from Question::createMultipleChoice
	*
	* @param $question_id
	* @param $question_type 'M', 'T', 'S', 'E', 'F', 'N'
	* @param $answer string
	* @param $is_correct (1, 0)
	*
	* @return boolean
	*/
	public function create($question_id, $question_type, $answer, $is_correct){
		
		$answer_order = $this->getNextAnswerOrder($question_id);
		
		$this->setAttributes(array(
	        	'QUESTION_ID'=>$question_id,
				'QUESTION_TYPE'=>$question_type,
	        	'ANSWER'=>$answer,
				'ANSWER_ORDER'=>$answer_order,
		        'IS_CORRECT'=>$is_correct,				
	    ),false);
		
		$this->save(false);
	
		return $this->ID;
	
	}


	
	
}