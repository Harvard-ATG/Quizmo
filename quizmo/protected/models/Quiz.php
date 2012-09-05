<?php

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
			'questions' => array(self::HAS_MANY, 'QUESTIONS', 'QUIZ_ID'),
			'collection' => array(self::BELONGS_TO, 'Collection', 'COLLECTION_ID'),
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
	    	'order'=>'ID ASC'
	    );
	}
	
	/**
	* This is meant to make printing a list easy...  json probably better, but this works for now...
	* @param integer $collection_id
	* @return array
	*/
	public function getQuizArrayByCollectionId($collection_id, $user_id){
		
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
				$qa[$key] = $value;
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
		$this->setAttributes(array(
	        	'COLLECTION_ID'=>$collection_id,
	        	'TITLE'=>$title,
		        'STATE'=>$state,
				'START_DATE'=>$start_date,
				'END_DATE'=>$end_date,
				'VISIBILITY'=>$visibility,
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
		return $quiz->COLLECTION_ID;
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
		
	}
	
}