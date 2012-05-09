<?php

/**
 * This is the model class for table "Questions".
 *
 * The followings are the available columns in table 'Questions':
 * @property integer $id
 * @property integer $quiz_id
 * @property string $question_type
 * @property string $title
 * @property string $body
 * @property integer $question_order
 * @property integer $points
 * @property string $feedback
 * @property integer $deleted
 */
class Question extends QActiveRecord
{
	
	public $sequenceName = 'QUESTIONS_SEQ';	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Question the static model class
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
		return 'QUESTIONS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('QUIZ_ID, QUESTION_TYPE, DELETED', 'required'),
			array('QUIZ_ID, QUESTION_ORDER, POINTS, DELETED', 'numerical', 'integerOnly'=>true),
			array('QUESTION_TYPE, TITLE, BODY, FEEDBACK', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, QUIZ_ID, QUESTION_TYPE, TITLE, BODY, QUESTION_ORDER, POINTS, FEEDBACK, DELETED', 'safe', 'on'=>'search'),
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
			'quiz' => array(self::BELONGS_TO, 'Quiz', 'QUIZ_ID'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'ID' => 'ID',
			'QUIZ_ID' => 'Quiz',
			'QUESTION_TYPE' => 'Question Type',
			'TITLE' => 'Title',
			'BODY' => 'Body',
			'QUESTION_ORDER' => 'Question Order',
			'POINTS' => 'Points',
			'FEEDBACK' => 'Feedback',
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

		$criteria->compare('ID',$this->ID);
		$criteria->compare('QUIZ_ID',$this->QUIZ_ID);
		$criteria->compare('QUESTION_TYPE',$this->QUESTION_TYPE,true);
		$criteria->compare('TITLE',$this->TITLE,true);
		$criteria->compare('BODY',$this->BODY,true);
		$criteria->compare('QUESTION_ORDER',$this->QUESTION_ORDER);
		$criteria->compare('POINTS',$this->POINTS);
		$criteria->compare('FEEDBACK',$this->FEEDBACK,true);
		$criteria->compare('DELETED',$this->DELETED);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	* getQuestionArrayByQuizId
	*
	*/
	public function getQuestionArrayByQuizId($quiz_id){
		
		
		
	}
	
	/**
	* getNextQuestionOrder
	*
	* originally thinking of this just to be used internally
	* when adding new questions -- to get the appropriate question_order
	*
	* @param $quiz_id int
	*
	* @return $quetion_order int
	*/
	public function getNextQuestionOrder($quiz_id){

		$criteria=new CDbCriteria;
		//$criteria->select = 'max(QUESTION_ORDER) AS max_question_order';
		$criteria->condition = 'quiz_id='.$quiz_id;
		$criteria->order = "question_order DESC";
		
		$question = Question::model()->find($criteria);
		
		if(isset($question->QUESTION_ORDER))
			return $question->QUESTION_ORDER+1;
		else
			return 1;

	}
	
	/**
	* createMultipleChoice
	*
	* @param $quiz_id string
	* @param $title string
	* @param $body string
	* @param $score int
	* @param $feedback string
	* @param $multiple_radio_answer int
	* @param $multiple_answers array of strings
	*
	* @return $question_id int
	*/
	public function createMultipleChoice($quiz_id, $title, $body, $score, $feedback, $multiple_radio_answer, $multiple_answers){
		
		if($quiz_id == '' || $title == '' || $body == ''){
			return false;
		}
		
		$question_order = $this->getNextQuestionOrder($quiz_id);
		
		$this->setAttributes(array(
	        	'QUIZ_ID'=>$quiz_id,
				'QUESTION_TYPE'=>'M',
	        	'TITLE'=>$title,
		        'BODY'=>$body,
				'QUESTION_ORDER'=>$question_order,
		        'POINTS'=>$score,
				'FEEDBACK'=>$feedback,
				'DELETED'=>0,
	    ),false);
		
		$this->save(false);
		$question_id = $this->ID;
		
		foreach($multiple_answers as $multiple_answer){
			$answer = new Answer;
			$answer->createMultipleChoiceAnswer($question_id, $multiple_answer['answer'], $multiple_answer['is_correct']);
		}
		
		
		return $this->ID;
		
	
	}
	
	
	
	
	
}