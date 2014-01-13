<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


/**
 * This is the model class for table "Quizzes".
 *
 * The followings are the available columns in table 'Quizzes': <br>
 * integer $ID <br>
 * integer $COLLECTION_ID <br>
 * string $TITLE <br>
 * string $DESCRIPTION <br>
 * integer $VISIBILITY <br>
 * string $STATE <br>
 * integer $SHOW_FEEDBACK <br>
 * string $START_DATE <br>
 * string $END_DATE <br>
 * string $DATE_MODIFIED <br>
 * integer $DELETED <br>
 *
 * @package app.Model
 */
class Quiz extends QActiveRecord
{
	
	const CLOSED = 'C';
	const OPEN = 'O';
	const SCHEDULED = 'S';
	
	const SCHEDULED_NOT_STARTED = 'N';
	const SCHEDULED_STARTED = 'S';
	const SCHEDULED_ENDED = 'E';
	
	/**
	 * this is needed by QActiveRecord for Oracle
	 * @var string
	 */
	public $sequenceName = 'QUIZZES_SEQ';	
	
	/**
	 * created originally by Yii's Gii
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Quiz the static model class
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
		return 'QUIZZES';
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
			array('COLLECTION_ID, TITLE, VISIBILITY, DELETED', 'required'),
			array('COLLECTION_ID, VISIBILITY, SHOW_FEEDBACK, DELETED', 'numerical', 'integerOnly'=>true),
			array('TITLE, STATE', 'length', 'max'=>255),
			array('DESCRIPTION', 'length', 'max'=>3900),
			//array('START_DATE, END_DATE, DATE_MODIFIED', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, COLLECTION_ID, TITLE, DESCRIPTION, VISIBILITY, STATE, SHOW_FEEDBACK, START_DATE, END_DATE, DATE_MODIFIED, DELETED', 'safe', 'on'=>'search'),
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
            'submissionCount' => array(self::STAT, 'Submission', 'quiz_id'),
			'questions' => array(self::HAS_MANY, 'QUESTIONS', 'QUIZ_ID'),
			'submissions' => array(self::HAS_MANY, 'Submission', 'QUIZ_ID'),
			'collections' => array(self::BELONGS_TO, 'COLLECTIONS', 'COLLECTION_ID'),
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
			'COLLECTION_ID' => 'Collection',
			'TITLE' => 'Title',
			'DESCRIPTION' => 'Description',
			'VISIBILITY' => 'Visibility',
			'STATE' => 'State',
			'SHOW_FEEDBACK' => 'Show Feedback',
			'SORT_ORDER' => 'Sort Order',
			'START_DATE' => 'Start Date',
			'END_DATE' => 'End Date',
			'DATE_MODIFIED' => 'Date Modified',
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
		$criteria->compare('COLLECTION_ID',$this->COLLECTION_ID);
		$criteria->compare('TITLE',$this->TITLE,true);
		$criteria->compare('DESCRIPTION',$this->DESCRIPTION,true);
		$criteria->compare('VISIBILITY',$this->VISIBILITY);
		$criteria->compare('STATE',$this->STATE,true);
		$criteria->compare('SHOW_FEEDBACK',$this->SHOW_FEEDBACK);
		$criteria->compare('START_DATE',$this->START_DATE,true);
		$criteria->compare('END_DATE',$this->END_DATE,true);
		$criteria->compare('DATE_MODIFIED',$this->DATE_MODIFIED,true);
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
	 * getNextQuizOrder
	 *
	 * originally thinking of this just to be used internally
	 * when adding new questions -- to get the appropriate sort_order
	 *
	 * @param integer $collection_id
	 * @return integer $sort_order
	 */
	public function getNextQuizOrder($collection_id){
		//error_log("getNextQuizOrder");
		$criteria=new CDbCriteria;
		//$criteria->select = 'max(SORT_ORDER) AS max_sort_order';
		$criteria->condition = 'collection_id='.$collection_id;
		$criteria->order = "sort_order DESC";
		
		$quiz = Quiz::model()->find($criteria);

		if(isset($quiz->SORT_ORDER))
			return $quiz->SORT_ORDER+1;
		else
			return 1;

	}


	/**
	* This is meant to make printing a list easy...  json probably better, but this works for now...
	* @param integer $collection_id
	* @return array
	*/
	public function getQuizArrayByCollectionId($collection_id, $user_id){
		//error_log("getQuizArrayByCollectionId");
		$quizzes = Quiz::model()->findAll('collection_id=:collection_id', array(':collection_id' => $collection_id));
		
		$quizArray = array();
		foreach($quizzes as $quiz){
			$qa = array();
			$qa['link'] = "/question/index/".$quiz->ID;
			$status = Submission::getStatusByUser($user_id, $quiz->ID);
			$qa['status'] = $status;
			$question_count = count(Quiz::getQuestionIds($quiz->ID));
			$qa['question_count'] = $question_count;
			$qa['isClosed'] = Quiz::isClosedByState($quiz->STATE, $quiz->START_DATE, $quiz->END_DATE);
			$qa['scheduleState'] = Quiz::scheduleState($quiz->START_DATE, $quiz->END_DATE);
			$qa['scheduleTimeTill'] = Quiz::scheduleTimeTill($quiz->START_DATE, $quiz->END_DATE);
			
			
			foreach($quiz as $key=>$value){
				$qa[$key] = htmlentities($value);
			}				
			array_push($quizArray, $qa);
		}
		return $quizArray;
	
	}
	
	/**
	* create
	* @param integer $collection_id
	* @param string $title
	* @param string $description
	* @param string $state
	* @param date $start_date
	* @param date $end_date
	* @param boolean $visibility
	* @param boolean $show_feedback
	* @return integer $this->ID
	*/
	public function create($collection_id, $title, $description, $state, $start_date, $end_date, $visibility=0, $show_feedback=0){
		
		if($title == ''){
			return false;
		}
		if($this->ID != null){
			$sort_order = $this->SORT_ORDER;
		} else {
			$sort_order = $this->getNextQuizOrder($collection_id);			
		}
		$this->setAttributes(array(
	        	'COLLECTION_ID'=>$collection_id,
	        	'TITLE'=>$title,
		        'STATE'=>$state,
				'START_DATE'=>$start_date,
				'END_DATE'=>$end_date,
				'VISIBILITY'=>$visibility,
				'SORT_ORDER'=>$sort_order,
				'SHOW_FEEDBACK'=>$show_feedback,
				'DELETED'=>0,
		        'DESCRIPTION'=>$description,
				
	    ),false);
		
		$this->save(false);
		return $this->ID;
		
	}
	
	/**
	* gets the array of question ids
	*
	* @param integer $quiz_id
	* @return array $question_ids array of ints
	*/
	public function getQuestionIds($quiz_id){
		
		$questions = Question::model()->findAll('quiz_id=:quiz_id', array(':quiz_id' => $quiz_id));
		$question_ids = array();
		foreach($questions as $question){
			array_push($question_ids, $question->ID);
		}
		
		return $question_ids;
		
	}
	
	/**
	 * simple get for a quiz object
	 *
	 * @param integer $quiz_id
	 * @return object Quiz
	 */
	public function getQuiz($quiz_id){
		$quiz = Quiz::model()->find('id=:quiz_id', array(':quiz_id'=>$quiz_id));
		return $quiz;
	}
	
	/**
	 * gets the collection_id
	 * @param number $quiz_id
	 * @return number $collection_id
	 */
	public function getCollectionId($quiz_id){
		$quiz = Quiz::model()->findByPk($quiz_id);
		if($quiz){
			return $quiz->COLLECTION_ID;
		} else {
			return false;
		}
	}
	
	/**
	 * sets the deleted flag
	 * @param number $quiz_id
	 * @return boolean
	 */
	public function setDeleted($quiz_id){
		$quiz = Quiz::model()->findByPk($quiz_id);
		$quiz->DELETED = 1;
		
		return($quiz->save());
		
	}
	
	/**
	 * gets a hash of question ids and points
	 * @param number $quiz_id
	 * @return hash $question->ID => $question->POINTS
	 */
	public function getQuestionPoints($quiz_id){
		$questions = Question::model()->findAllByAttributes(array('QUIZ_ID'=>$quiz_id));
		$hash = array();
		
		foreach($questions as $question){
			$hash[$question->ID] = $question->POINTS;
		}
		
		return $hash;
		
	}
	
	/**
	 * determine state
	 * @param string $state
	 * @param string $start_date
	 * @param string $end_date
	 * @return boolean true is hidden, false is not
	 */
	public function isClosedByState($state, $start_date='', $end_date=''){
		
		switch($state){
			case Quiz::CLOSED:
				return true;
			break;
			case Quiz::OPEN:
				return false;
			break;
			case Quiz::SCHEDULED:
				//echo("\nSCHEDULED\n");
				//$start_datetime = DateTime::createFromFormat("Y-m-d", $start_date);
				//$end_datetime = DateTime::createFromFormat("Y-m-d", $end_date);
				$start_datetime = new DateTime($start_date);
				$end_datetime = new DateTime($end_date);
				
				$now_datetime = new DateTime;
				
				if($start_datetime < $now_datetime && $now_datetime < $end_datetime){
					return false;
				} else {
					return true;
				}
				
			break;
		}
		return null;
	}
	
	/**
	 * gets the schedule state given the start and end date
	 * @param date $start_date
	 * @param date $end_date
	 * @return char Quiz::SCHEDULED_STARTED or Quiz::SCHEDULED_NOT_STARTED or SCHEDULED_ENDED
	 */
	public function scheduleState($start_date='', $end_date=''){
		$start_datetime = new DateTime($start_date);
		$end_datetime = new DateTime($end_date);
		$now_datetime = new DateTime;
		
		if($start_datetime < $now_datetime && $now_datetime < $end_datetime){
			return Quiz::SCHEDULED_STARTED;
		} elseif($now_datetime < $start_datetime){
			return Quiz::SCHEDULED_NOT_STARTED;			
		} elseif($now_datetime > $end_datetime){
			return Quiz::SCHEDULED_ENDED;			
		}
		
		return false;
		
	}
	
	/**
	 * gets the time till next event or days after the end
	 * @param date $start_date
	 * @param date $end_date
	 * @return number days till next event
	 */
	public function scheduleTimeTill($start_date='', $end_date=''){
		$start_datetime = new DateTime($start_date);
		$end_datetime = new DateTime($end_date);
		$now_datetime = new DateTime;
		
		$timeToStart = $now_datetime->diff($start_datetime);
		$timeToEnd = $now_datetime->diff($end_datetime);
		
		if($start_datetime < $now_datetime && $now_datetime < $end_datetime){
			// we have started so we need the time to end
			return $timeToEnd->d;
		} elseif($now_datetime < $start_datetime){
			// we haven't started so we need the time till start
			return $timeToStart->d;
		} elseif($now_datetime > $end_datetime){
			// we have ended so we need the time from end
			return $timeToEnd->d;
		}
				
	}
	
	/**
	 * resets the quiz my removing all results associated with the quiz
	 * @param number $quiz_id
	 * @return boolean
	 */
	public function reset($quiz_id){
		$question_ids = Quiz::getQuestionIds($quiz_id);
		// remove all responses
		$responses = Response::model()->deleteAllByAttributes(array('QUESTION_ID'=>$question_ids));
		// remove all submissions
		$submissions = Submission::model()->deleteAllByAttributes(array('QUIZ_ID'=>$quiz_id));
		
		// reset settings
		Quiz::resetSettings($quiz_id);
		return true;
	}
	
	/**
	 * resets the quiz settings
	 * just sets the quiz to invisible and closed
	 */
	 public function resetSettings($quiz_id){
		 
		 // get the quiz
		 $quiz = Quiz::model()->findByPk($quiz_id);
		 // set the quiz state
		 $quiz->STATE = Quiz::CLOSED;
		 // set the quiz visibility
		 $quiz->VISIBILITY = 0;
		 // save
		 if($quiz->save()){
			 return true;
		 }
		 return false;
	 }
	
	/**
	 * reorders the quiz item
	 * @param number $quiz_id
	 * @param number $fromPosition
	 * @param number $toPosition
	 * @return boolean success
	 */
	public function reorder($quiz_id, $fromPosition, $toPosition){
		//echo("reorder($quiz_id, $fromPosition, $toPosition)\n");
		
		// redo this
		// get the list of quiz_ids
		$quizzes = Quiz::model()->findAllByAttributes(array('COLLECTION_ID'=>Quiz::getCollectionId($quiz_id)));
		$quiz_id_array = array();
		foreach($quizzes as $quiz){
			if($quiz->ID == $quiz_id)
				array_push($quiz_id_array, "XXX");
			else
				array_push($quiz_id_array, $quiz->ID);
		}
		$count = sizeof($quiz_id_array);
		
		// put the quiz_id in the right spot array_splice
		if($toPosition < $fromPosition)
			$toPosition -= 1;
		array_splice($quiz_id_array, $toPosition, 0, $quiz_id);
			
		// remove the old one
		$sort_order = 1;
		// run through the list, updating sort_orders
		foreach($quiz_id_array as $q_id){
			if($q_id != "XXX"){
				$quiz = Quiz::model()->findByPk($q_id);
				if($quiz != null){
					$quiz->SORT_ORDER = $sort_order;
					$quiz->save();
					$sort_order++;
				} else {
					error_log("Quiz::reorder failure");
					return false;
				}
			}
		}
	
	}
	
	/**
	 * copies quiz, questions, answers (not responses)
	 * @param number $quiz_id
	 * @return boolean success
	 */
	public function copy($quiz_id){
		// get quiz
		$quiz = Quiz::model()->findByPk($quiz_id);
		// remove id, rename by appending (copy)
		$quiz->ID = null;
		$quiz->TITLE .= " (copy)";
		// copy quiz
		$quiz->setIsNewRecord(true);
		$quiz->save();
		$new_id = $quiz->ID;
		
		// get questions
		$questions = Question::model()->findAllByAttributes(array('QUIZ_ID'=>$quiz_id));
		// copy questions
		foreach($questions as $question){
			// get answers
			$answers = Answer::model()->findAllByAttributes(array('QUESTION_ID'=>$question->ID));

			// copy question
			$question->ID = null;
			$question->setIsNewRecord(true);
			$question->QUIZ_ID = $new_id;
			$question->save();
			$new_question_id = $question->ID;
			// copy answers
			foreach($answers as $answer){
				$answer->ID = null;
				$answer->setIsNewRecord(true);
				$answer->QUESTION_ID = $new_question_id;
				$answer->save();
			}
		}
		
		// reset settings of new quiz
		Quiz::resetSettings($new_id);
		return $new_id;
		
	}
	
	/**
	 * returns an array
	 * @param number $quiz_id
	 * @return array results that would be in a spreadsheety thing
	 */
	public function exportArray($quiz_id){
		// get the quiz
		$quiz = Quiz::model()->findByPk($quiz_id);
		$output = array();
		$output[0] = array($quiz->TITLE);
		$output[1] = array("Responses and Scores");
		$output[2] = array(date("D, M j, Y \a\\t g:i A"));
		
		// now the column headers
		// last name, first name, email
		// we need to get all the basic question data: 
		// nah, let's not do that, the old one just goes "Question 1 Response  Question 1 Score  Question 2 Response..."
		// we'll do that
		$outputInner = array("Last Name", "First Name", "Email");
		$question_ids = Quiz::getQuestionIds($quiz_id);
		$count = 1;
		foreach($question_ids as $question_id){
			array_push($outputInner, "Question $count Response");		
			array_push($outputInner, "Question $count Score");
			$count++;	
		}
		array_push($output, $outputInner);
		
		// get the responses
		//$question_ids_string = "(".join(",", $question_ids).")";
		//$responses = Response::model()->findAll('QUESTION_ID IN '.$question_ids_string);
		
		// if I get all reponses by question_id by running through the question_ids, they'll be in the right order
		$users = array();
		$user_ids = array();
		$count = 0;
		foreach($question_ids as $question_id){
			
			$responses = Response::model()->findAllByAttributes(array('QUESTION_ID'=>$question_id));
			// put them into an array based on user_ids
			foreach($responses as $response){
				//if(!isset($users[$response->USER_ID]['responses'][$count]['response'])){
				if(in_array($response->QUESTION_TYPE, array(Question::MULTIPLE_CHOICE, Question::MULTIPLE_SELECTION, Question::TRUE_FALSE))){
					// in this case, the answer comes from answer, not response
					// get the question associated with this answer_id stored in the response
					$answer = Answer::model()->findByPk($response->RESPONSE);

					// it's possible to have an empty response for these if they visited the question, but didn't actually answer it
					if($answer != null){
						if(!isset($users[$response->USER_ID]['responses'][$count]['response'])){
							$users[$response->USER_ID]['responses'][$count]['response'] = $answer->ANSWER;
							error_log("response: ".$users[$response->USER_ID]['responses'][$count]['response']);
						} else {
							$users[$response->USER_ID]['responses'][$count]['response'] .= ",".$answer->ANSWER;
							error_log("response: ".$users[$response->USER_ID]['responses'][$count]['response']);
						}
					} else {
						$users[$response->USER_ID]['responses'][$count]['response'] = "";
					}
						
				} else {
						$users[$response->USER_ID]['responses'][$count]['response'] = $response->RESPONSE;
				}
				//} else {
					//$users[$response->USER_ID]['responses'][$count]['response'] .= ",".$response->RESPONSE;
				//}
				@$users[$response->USER_ID]['responses'][$count]['score'] += $response->SCORE;
				array_push($user_ids, $response->USER_ID);
			}
			$count++;
			
			
		}
		
		
		// get all users
		if(!empty($user_ids)){
			$usersO = User::model()->findAll('ID IN ('.join(",", $user_ids).')');
			foreach($usersO as $user){
				$users[$user->ID]['lname'] = $user->LNAME;
				$users[$user->ID]['fname'] = $user->FNAME;
				$users[$user->ID]['email'] = $user->EMAIL;
			}
		}
		
		//echo(var_export($users, 1));
		
		// put them all into the output
		foreach($users as $user){
			$outputInner = array();
			array_push($outputInner, $user['lname']);
			array_push($outputInner, $user['fname']);
			array_push($outputInner, $user['email']);
			foreach($user['responses'] as $resp){
				array_push($outputInner, $resp['response']);
				array_push($outputInner, $resp['score']);
			}
			array_push($output, $outputInner);
		}
		
		return $output;
		
	}
	
	/**
	 * returns a csv of the results
	 * @param number $quiz_id
	 * @return string csv results 
	 */
	public function exportCSV($quiz_id){
		$exportArr = Quiz::exportArray($quiz_id);
		$output = '';
		//echo(var_export($exportArr, 1));
		foreach($exportArr as $lineArr){
			if(is_array($lineArr)){
				foreach($lineArr as $item){
					//$item = preg_replace('/\n/', "<br/>", $item);
					//$item = preg_replace('/\t/', "    ", $item);
					$output .= "\"".$item."\"\t";
				}
				$output = preg_replace('/\t$/', "\n", $output);			
			} else {
				$output .= $lineArr."\n";
			}
		}
		return htmlentities($output);
	
	}
	
	public function exportXLS($quiz_id){
		$data = Quiz::exportArray($quiz_id);
		Yii::import('application.extensions.phpexcel.JPhpExcel');
		$xls = new JPhpExcel('UTF-8', false, 'My Test Sheet');
		$xls->addArray($data);
		$xls->generateXML('results');
	}
	
}

?>