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
	* this is just to simplify the array vars for the view
	*
	* @param $quiz_id
	*
	* @return array()
	* array(
	* 	array(ID, QUIZ_ID, QUESTION_TYPE, TITLE, BODY, QUESTION_ORDER, POINTS, FEEDBACK, DELETED, link)
	* )
	*/
	public function getQuestionArrayByQuizId($quiz_id){
		
		error_log($quiz_id);
		$questions = Question::model()->findAll('quiz_id=:quiz_id', array(':quiz_id' => $quiz_id));
		
		$questionArray = array();
		foreach($questions as $question){
			$qa = array();
			$qa['link'] = "/question/view/".$question->ID;
			foreach($question as $key=>$value){
				$qa[$key] = $value;
			}
			array_push($questionArray, $qa);
		}
		return $questionArray;
		
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
		error_log("getNextQuestionOrder");
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
	* create
	*
	* Base model method for all questions (doesn't handle any answers)
	*
	* @param $quiz_id string
	* @param $title string
	* @param $body string
	* @param $score int
	* @param $feedback string
	*
	* @return $question_id int
	*/
	public function create($quiz_id, $question_type, $title, $body, $score, $feedback){
		if($title == '' || $body == ''){
			return false;
		}
		
		$question_order = $this->getNextQuestionOrder($quiz_id);
		$this->setAttributes(array(
	        	'QUIZ_ID'=>$quiz_id,
				'QUESTION_TYPE'=>$question_type,
	        	'TITLE'=>$title,
		        'BODY'=>$body,
				'QUESTION_ORDER'=>$question_order,
		        'POINTS'=>$score,
				'FEEDBACK'=>$feedback,
				'DELETED'=>0,
	    ),false);
		
		$this->save(false);
		
		return $this->ID;
		
	
	}

	
	/**
	* createMultipleChoice
	*
	* This can function for both Multiple-Choice and Check-All-that-Apply
	* It also calls the create for all associated answers that were passed to it
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
	public function createMultipleChoice($quiz_id, $question_type, $title, $body, $score, $feedback, $multiple_answers){
		
		$question_id = $this->create($quiz_id, $question_type, $title, $body, $score, $feedback);
				
		foreach($multiple_answers as $multiple_answer){
			$answer = new Answer;
			$answer->create($question_id, $question_type, $multiple_answer['answer'], $multiple_answer['is_correct']);
		}
		
		return $question_id;
		
	
	}
	
	//$question_id = $question->createTrueFalse($quiz_id, $title, $body, $score, $feedback, $truefalse);
	/**
	* createTrueFalse
	*
	* @param $quiz_id string
	* @param $title string
	* @param $body string
	* @param $score int
	* @param $feedback string
	* @param $truefalse bool
	*
	* @return $question_id int
	*/
	public function createTrueFalse($quiz_id, $title, $body, $score, $feedback, $truefalse){

		$question_id = $this->create($quiz_id, 'T', $title, $body, $score, $feedback);
				
		if($truefalse){
			$true = 1;
			$false = 0;
		} else {
			$true = 0;
			$false = 1;			
		}
		$answer = new Answer;
		$answer->create($question_id, 'T', 'true', $true);
		$answer = new Answer;
		$answer->create($question_id, 'T', 'false', $false);
		
		return $question_id;
		
	}
	
	/**
	* createEssay
	*
	* @param $quiz_id string
	* @param $title string
	* @param $body string
	* @param $score int
	* @param $feedback string
	* @param $textarea_rows int
	*
	* @return $question_id int
	*/
	public function createEssay($quiz_id, $title, $body, $score, $feedback, $textarea_rows){
		
		$question_id = $this->create($quiz_id, 'E', $title, $body, $score, $feedback);
				
		$answer = new Answer;
		$answer->create($question_id, 'E', '', 0, $textarea_rows);
		
		return $question_id;
		
	}

	/**
	* createNumerical
	*
	* @param $quiz_id string
	* @param $title string
	* @param $body string
	* @param $score int
	* @param $feedback string
	* @param $tolerance float
	*
	* @return $question_id int
	*/
	public function createNumerical($quiz_id, $title, $body, $score, $feedback, $tolerance){
		
		$question_id = $this->create($quiz_id, 'E', $title, $body, $score, $feedback);
				
		$answer = new Answer;
		$answer->create($question_id, 'E', '', 0, 10, 0, $tolerance);
		
		return $question_id;
		
	}

	/**
	* createFillin
	*
	* @param $quiz_id string
	* @param $title string
	* @param $body string
	* @param $score int
	* @param $feedback string
	* @param $is_case_sensitive bool
	*
	* @return $question_id int
	*/
	public function createFillin($quiz_id, $title, $body, $score, $feedback, $is_case_sensitive){
		
		$question_id = $this->create($quiz_id, 'E', $title, $body, $score, $feedback);
				
		$answer = new Answer;
		$answer->create($question_id, 'E', '', 0, 0, $is_case_sensitive, 0);
		
		return $question_id;
		
	}
	
}