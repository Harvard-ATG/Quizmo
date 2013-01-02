<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


/**
 * This is the model class for table "Questions".
 *
 * The followings are the available columns in table 'Questions': <br>
 * integer $id <br>
 * integer $quiz_id <br>
 * string $question_type <br>
 * string $title <br>
 * string $body <br>
 * integer $sort_order <br>
 * integer $points <br>
 * string $feedback <br>
 * integer $deleted <br>
 * @package app/Model
 */
class Question extends QActiveRecord
{
	
	const ESSAY = 'E';
	const MULTIPLE_CHOICE = 'M';
	const MULTIPLE_SELECTION = 'S';
	const FILLIN = 'F';
	const TRUE_FALSE = 'T';
	const NUMERICAL = 'N';
	
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
			array('QUIZ_ID, SORT_ORDER, POINTS, DELETED', 'numerical', 'integerOnly'=>true),
			array('QUESTION_TYPE, TITLE, FEEDBACK', 'length', 'max'=>255),
			array('BODY', 'length', 'max'=>3900),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, QUIZ_ID, QUESTION_TYPE, TITLE, BODY, SORT_ORDER, POINTS, FEEDBACK, DELETED', 'safe', 'on'=>'search'),
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
			'answers' => array(self::HAS_MANY, 'Answer', 'QUESTION_ID'),
			'responses' => array(self::HAS_MANY, 'Response', 'QUESTION_ID'),
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
			'SORT_ORDER' => 'Question Order',
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
		$criteria->compare('SORT_ORDER',$this->SORT_ORDER);
		$criteria->compare('POINTS',$this->POINTS);
		$criteria->compare('FEEDBACK',$this->FEEDBACK,true);
		$criteria->compare('DELETED',$this->DELETED);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * defaultScope ensures that every find operation makes sure it's not deleted
	 */
	public function defaultScope()
	{
	    return array(
		    'condition'=>'DELETED!=1',
	    	'order'=>'SORT_ORDER ASC, ID ASC'
	    );
	}
	
	/**
	* getQuestionArrayByQuizId
	*
	* this is just to simplify the array vars for the view
	*
	* @param integer $quiz_id
	* @return array()
	* array(
	* 	array(ID, QUIZ_ID, QUESTION_TYPE, TITLE, BODY, SORT_ORDER, POINTS, FEEDBACK, DELETED, link)
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
	* when adding new questions -- to get the appropriate sort_order
	*
	* @param integer $quiz_id
	* @return integer $sort_order
	*/
	public function getNextQuestionOrder($quiz_id){
		//error_log("getNextQuestionOrder");
		$criteria=new CDbCriteria;
		//$criteria->select = 'max(SORT_ORDER) AS max_sort_order';
		$criteria->condition = 'quiz_id='.$quiz_id;
		$criteria->order = "sort_order DESC";
		
		$question = Question::model()->find($criteria);

		if(isset($question->SORT_ORDER))
			return $question->SORT_ORDER+1;
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
		
		if($this->ID != null){
			$sort_order = $this->SORT_ORDER;
		} else {
			$sort_order = $this->getNextQuestionOrder($quiz_id);			
		}
		$this->setAttributes(array(
	        	'QUIZ_ID'=>$quiz_id,
				'QUESTION_TYPE'=>$question_type,
	        	'TITLE'=>$title,
		        'BODY'=>$body,
				'SORT_ORDER'=>$sort_order,
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
				
		// first remove all answers
		// get all answers
		$answers = Answer::model()->findAllByAttributes(array('QUESTION_ID'=>$question_id));
		// run through them
		foreach($answers as $answer){
			// delete them all
			$answer->delete();
		}
		
		// then run through the answers...
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

		$question_id = $this->create($quiz_id, Question::TRUE_FALSE, $title, $body, $score, $feedback);
				
		// first remove all answers
		// get all answers
		$answers = Answer::model()->findAllByAttributes(array('QUESTION_ID'=>$question_id));
		// run through them
		foreach($answers as $answer){
			// delete them all
			$answer->delete();
		}

		if($truefalse){
			$true = 1;
			$false = 0;
		} else {
			$true = 0;
			$false = 1;			
		}
		$answer = new Answer;
		$answer->create($question_id, Question::TRUE_FALSE, 'True', $true);
		$answer = new Answer;
		$answer->create($question_id, Question::TRUE_FALSE, 'False', $false);
		
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
		
		$question_id = $this->create($quiz_id, Question::ESSAY, $title, $body, $score, $feedback);

		// first remove all answers
		// get all answers
		$answers = Answer::model()->findAllByAttributes(array('QUESTION_ID'=>$question_id));
		// run through them
		foreach($answers as $answer){
			// delete them all
			$answer->delete();
		}
				
		$answer = new Answer;
		$answer->create($question_id, Question::ESSAY, '', 0, $textarea_rows);
		
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
	* @param float $numerical_answer 
	* @param float $tolerance 
	*
	* @return integer $question_id 
	*/
	public function createNumerical($quiz_id, $title, $body, $score, $feedback, $numerical_answer, $tolerance){
		
		$question_id = $this->create($quiz_id, Question::NUMERICAL, $title, $body, $score, $feedback);
				
		// first remove all answers
		// get all answers
		$answers = Answer::model()->findAllByAttributes(array('QUESTION_ID'=>$question_id));
		// run through them
		foreach($answers as $answer){
			// delete them all
			$answer->delete();
		}

		$answer = new Answer;
		$answer->create($question_id, Question::NUMERICAL, $numerical_answer, 0, 10, 0, $tolerance);
		
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
		
		$question_id = $this->create($quiz_id, Question::FILLIN, $title, $body, $score, $feedback);
		
		// need to get the answers from the body:
		preg_match_all("/\{[^}]*\}/", $body, $matches);
		foreach($matches as $val){
			foreach($val as $key => $match){
				$match = preg_replace("/[\{\}]/", "", $match);

				$answer = new Answer;
				$answer->create($question_id, Question::FILLIN, $match, 0, 0, $is_case_sensitive, 0);			
			
			}
			
		}
				
		
		return $question_id;
		
	}
	
	/**
	 * getQuestionViewById
	 *
	 * this should return the question and answers in an array that will be easily interpretted by the template
	 * @param integer $question_id
	 * @param integer $user_id
	 * @return array
	 */
	public function getQuestionViewById($question_id, $user_id=null){
		$question = Question::model()->findByPk($question_id);
		if($question == null){
			return null;
		}
		$answers = $question->answers;
		if($user_id)
			$responses = Response::model()->findAllByAttributes(array('USER_ID'=>$user_id, 'QUESTION_ID'=>$question_id));

		$questionArr = array();
		foreach($question as $key => $value){
			$questionArr[strtolower($key)] = $value;
			
		}

		// responses
		if($user_id){
			$responseArr = array();
			foreach($responses as $response){
				$responseInnerArr = array();
				foreach($response as $key => $value){
					$responseInnerArr[strtolower($key)] = $value;		
				}
				array_push($responseArr, $responseInnerArr);
			}
			$questionArr['responses'] = $responseArr;
		}
		
		// answers
		$answerArr = array();
		foreach($answers as $answer){
			$answerInnerArr = array();
			foreach($answer as $key => $value){
				$answerInnerArr[strtolower($key)] = $value;		
			}

			// for mc ms and tf the answer arr needs to know if it's answered
			if(Response::isAnswerSelected($user_id, $answer->ID)){
				$answerInnerArr['response'] = true;
			} else {
				$answerInnerArr['response'] = false;
			}			
			
			array_push($answerArr, $answerInnerArr);
		}
		$questionArr['answers'] = $answerArr;
		
		return $questionArr;
	}
	
	/**
	 * getQuestionViewByQuizIdUserId
	 *
	 * this should return the question and answers in an array that will be easily interpretted by the template
	 * @param integer $question_id
	 *
	 * @return array
	 */
	public function getQuestionViewsByQuizIdUserId($quiz_id, $user_id){
		$questions = Question::model()->sort_order()->findAllByAttributes(array('QUIZ_ID'=>$quiz_id));

		$output = array();
		foreach($questions as $question){
			$score = 0;
			$answers = $question->answers;
			$responses = Response::model()->findAllByAttributes(array('USER_ID'=>$user_id, 'QUESTION_ID'=>$question->ID));

			// questions
			$questionArr = array();
			foreach($question as $key => $value){
				if($key == 'POINTS' && $value == ''){
					$value = 0;
				}
				$questionArr[strtolower($key)] = $value;
			
			}
			
			// responses
			$responseArr = array();
			foreach($responses as $response){
				$responseInnerArr = array();
				foreach($response as $key => $value){
					if($key == 'SCORE'){
						$score += $value;
					}
					$responseInnerArr[strtolower($key)] = $value;		
				}
				array_push($responseArr, $responseInnerArr);
			}
			$questionArr['responses'] = $responseArr;

			if(sizeof($responseArr) == 0){
				$questionArr['responses'][0]['id'] = '';
				$questionArr['responses'][0]['response'] = '';
			}
			
			// answers
			$answerArr = array();
			foreach($answers as $answer){
				$answerInnerArr = array();
				foreach($answer as $key => $value){
					$answerInnerArr[strtolower($key)] = $value;		
				}

				// for mc ms and tf the answer arr needs to know if it's correctly answered
				if(Response::isAnswerSelected($user_id, $answer->ID)){
					$answerInnerArr['response'] = true;
				} else {
					$answerInnerArr['response'] = false;
				}
				
				array_push($answerArr, $answerInnerArr);

			}
			$questionArr['answers'] = $answerArr;
			
			$questionArr['score'] = $score;
		
			array_push($output, $questionArr);
		}
		
		return $output;
	
	}

	/**
	 * getQuestionViewById
	 *
	 * this should return the question and answers in an array that will be easily interpretted by the template
	 * @param integer $question_id
	 *
	 * @return array
	 */
	public function getQuestionViewsByQuizId($quiz_id){
		$questions = Question::model()->sort_order()->findAllByAttributes(array('QUIZ_ID'=>$quiz_id));

		$output = array();
		foreach($questions as $question){
			$score = 0;
			$answers = $question->answers;
			$responses = Response::model()->findAllByAttributes(array('QUESTION_ID'=>$question->ID));
			
			$userArr = array();

			// responses
			$responseArr = array();
			foreach($responses as $response){
				$responseInnerArr = array();
				foreach($response as $key => $value){
					if($key == 'SCORE'){
						$score += $value;
					}
					$responseInnerArr[strtolower($key)] = $value;		
				}
				array_push($responseArr, $responseInnerArr);
			}
			$questionArr['responses'] = $responseArr;


			// questions
			$questionArr = array();
			foreach($question as $key => $value){
				if($key == 'POINTS' && $value == ''){
					$value = 0;
				}
				$questionArr[strtolower($key)] = $value;
			
			}
			

			if(sizeof($responseArr) == 0){
				$questionArr['responses'][0]['id'] = '';
				$questionArr['responses'][0]['response'] = '';
			}
			
			// answers
			$answerArr = array();
			foreach($answers as $answer){
				$answerInnerArr = array();
				foreach($answer as $key => $value){
					$answerInnerArr[strtolower($key)] = $value;		
				}

				// for mc ms and tf the answer arr needs to know if it's correctly answered
				if(Response::isAnswerSelected($user_id, $answer->ID)){
					$answerInnerArr['response'] = true;
				} else {
					$answerInnerArr['response'] = false;
				}
				
				array_push($answerArr, $answerInnerArr);

			}
			$questionArr['answers'] = $answerArr;
			
			$questionArr['score'] = $score;
		
			array_push($output, $questionArr);
		}
		
		return $output;
	
	}
	
	/**
	 * gets the total score from the questions
	 * @param number $quiz_id
	 * @return number score
	 */
	public function getTotalScore($quiz_id){
		$questions = Question::model()->findAllByAttributes(array('QUIZ_ID'=>$quiz_id));
		$score = 0;
		foreach($questions as $question){
			$score += $question->POINTS;
		}
		return $score;
	}
	
	/**
	 * gets the quiz_id
	 * @param number $question_id
	 * @return number $quiz_id
	 */
	public function getQuizId($question_id){
		$question = Question::model()->findByPk($question_id);
		return $question->QUIZ_ID;
		
	}
	
	/**
	 * sets the deleted flag
	 * @param number $question_id
	 * @return boolean
	 */
	public function setDeleted($question_id){
		$question = Question::model()->findByPk($question_id);
		$question->DELETED = 1;
		
		return($question->save());
		
	}
	
	/**
	 * reorders the question item
	 * @param number $question_id
	 * @param number $fromPosition
	 * @param number $toPosition
	 * @return boolean success
	 */
	public function reorder($question_id, $fromPosition, $toPosition){
		//error_log("reorder($question_id, $fromPosition, $toPosition)\n");
		
		// redo this
		// get the list of quiz_ids
		$questions = Question::model()->findAllByAttributes(array('QUIZ_ID'=>Question::getQuizId($question_id)));
		$question_id_array = array();
		foreach($questions as $question){
			if($question->ID == $question_id)
				array_push($question_id_array, "XXX");
			else
				array_push($question_id_array, $question->ID);
		}
		
		
		// put the quiz_id in the right spot array_splice
		if($toPosition < $fromPosition)
			$toPosition -= 1;
		array_splice($question_id_array, $toPosition, 0, $question_id);
			
		// remove the old one
		$sort_order = 1;
		// run through the list, updating sort_orders
		foreach($question_id_array as $q_id){
			if($q_id != "XXX"){
				$question = Question::model()->findByPk($q_id);
				if($question != null){
					$question->SORT_ORDER = $sort_order;
					$question->save();
					$sort_order++;
				} else {
					error_log("Question::reorder failure\n");
					return false;
				}
			}
		}

	}	

	
}
