<?php

/**
 * This is the model class for table "Questions".
 *
 * The followings are the available columns in table 'Questions': <br>
 * integer $id <br>
 * integer $quiz_id <br>
 * string $question_type <br>
 * string $title <br>
 * string $body <br>
 * integer $question_order <br>
 * integer $points <br>
 * string $feedback <br>
 * integer $deleted <br>
 * @package app/Model
 */
class Question extends QActiveRecord
{
	
	/**
	 * this is needed by QActiveRecord for Oracle
	 * @var string
	 */
	public $sequenceName = 'QUESTIONS_SEQ';	
	
	/**
	 * created originally by Yii's Gii
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Question the static model class
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
		return 'QUESTIONS';
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
			array('QUIZ_ID, QUESTION_TYPE, DELETED', 'required'),
			array('QUIZ_ID, QUESTION_ORDER, POINTS, DELETED', 'numerical', 'integerOnly'=>true),
			array('QUESTION_TYPE, TITLE, BODY, FEEDBACK', 'length', 'max'=>255),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, QUIZ_ID, QUESTION_TYPE, TITLE, BODY, QUESTION_ORDER, POINTS, FEEDBACK, DELETED', 'safe', 'on'=>'search'),
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
			'quiz' => array(self::BELONGS_TO, 'Quiz', 'QUIZ_ID'),
			'answer' => array(self::HAS_MANY, 'Answer', 'QUESTION_ID'),
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
	* @param integer $quiz_id
	* @return array()
	* array(
	* 	array(ID, QUIZ_ID, QUESTION_TYPE, TITLE, BODY, QUESTION_ORDER, POINTS, FEEDBACK, DELETED, link)
	* )
	*/
	public function getQuestionArrayByQuizId($quiz_id){
		
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
	* @param integer $quiz_id
	* @return integer $quetion_order
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
	* @param string $quiz_id 
	* @param string $question_type
	* @param string $title 
	* @param string $body 
	* @param integer $score 
	* @param string $feedback 
	*
	* @return integer $question_id 
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
	* @param string $quiz_id
	* @param string $question_type
	* @param string $title 
	* @param string $body 
	* @param integer $score 
	* @param string $feedback 
	* @param array $multiple_answers array of strings
	*
	* @return integer $question_id
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
	* @param string $quiz_id 
	* @param string $title 
	* @param string $body 
	* @param integer $score 
	* @param string $feedback 
	* @param boolean $truefalse 
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
	* @param string $quiz_id 
	* @param string $title 
	* @param string $body 
	* @param integer $score 
	* @param string $feedback 
	* @param integer $textarea_rows 
	*
	* @return integer $question_id 
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
	* @param integer $quiz_id 
	* @param string $title 
	* @param string $body 
	* @param integer $score 
	* @param string $feedback 
	* @param float $tolerance 
	*
	* @return integer $question_id 
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
	* @param integer $quiz_id 
	* @param string $title 
	* @param string $body 
	* @param integer $score 
	* @param string $feedback 
	* @param boolean $is_case_sensitive 
	*
	* @return $question_id int
	*/
	public function createFillin($quiz_id, $title, $body, $score, $feedback, $is_case_sensitive){
		
		$question_id = $this->create($quiz_id, 'E', $title, $body, $score, $feedback);
				
		$answer = new Answer;
		$answer->create($question_id, 'E', '', 0, 0, $is_case_sensitive, 0);
		
		return $question_id;
		
	}
	
	/**
	* getQuestionViewById
	*
	* this should return the question and answers in an array that will be easily interpretted by the template
	* @param integer $question_id
	*
	* @return array
	*/
	public function getQuestionViewById($question_id){
		$question = Question::model()->findByPk($question_id);
		$answers = $question->answer;
		error_log(sizeof($answers));

		$questionArr = array();
		foreach($question as $key => $value){
			$questionArr[strtolower($key)] = $value;
			
		}
		$answerArr = array();
		foreach($answers as $answer){
			$answerInnerArr = array();
			foreach($answer as $key => $value){
				$answerInnerArr[strtolower($key)] = $value;		
			}
			array_push($answerArr, $answerInnerArr);
		}
		$questionArr['answers'] = $answerArr;
		
		return $questionArr;
	}
	
}