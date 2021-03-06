<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


/**
 * self explanitory exception
 */
class SubmittingUnstartedQuizException extends Exception { }


/**
 * This is the model class for table "Submissions".
 *
 * The followings are the available columns in table 'Submissions':
 * @property integer $ID
 * @property integer $QUIZ_ID
 * @property integer $USER_ID
 * @property string $STATUS
 * @property string $DATE_MODIFIED
 */
class Submission extends QActiveRecord
{
	
	const NOT_STARTED = 'N'; // this one may never be used
	const STARTED = 'U';
	const UNFINISHED = 'U';
	const SUBMITTED = 'S';
	const FINISHED = 'F';
	const GRADED = 'F';
	
	
	public $sequenceName = 'SUBMISSIONS_SEQ';
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Submission the static model class
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
		return 'SUBMISSIONS';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('QUIZ_ID, USER_ID', 'numerical', 'integerOnly'=>true),
			array('STATUS', 'length', 'max'=>255),
			array('DATE_MODIFIED', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('ID, QUIZ_ID, USER_ID, STATUS, DATE_MODIFIED', 'safe', 'on'=>'search'),
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
			'quizzes' => array(self::BELONGS_TO, 'Quiz', 'QUIZ_ID'),
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
			'USER_ID' => 'User',
			'STATUS' => 'Status',
			'DATE_MODIFIED' => 'Date Modified',
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
		$criteria->compare('QUIZ_ID',$this->quiz_id);
		$criteria->compare('USER_ID',$this->user_id);
		$criteria->compare('STATUS',$this->status,true);
		$criteria->compare('DATE_MODIFIED',$this->date_modified,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * set the submission for the given user and quiz to started/unfinished
	 * @param number $user_id
	 * @param number $quiz_id
	 */
	public function startQuiz($user_id, $quiz_id){
		
		$submission = Submission::model()->find('user_id=:user_id AND quiz_id=:quiz_id', 
			array(
				':user_id' => $user_id,			
				':quiz_id' => $quiz_id,			
			)
		);

		if($submission == null){
			// create new user
			$submission = new Submission;
			
			// NOTE: if you are doing auto-increment, this->ID will be overwritten with whatever
			//    the sequence is at at the save()

			$submission->USER_ID = $user_id;
			$submission->QUIZ_ID = $quiz_id;
			$submission->STATUS = Submission::STARTED;

			$submission->save();

		} else { 
			// do nothing, the submission already exists
		}
		
	}
	
	/**
	 * set the submission for the given user and quiz to submitted
	 * @param number $user_id
	 * @param number $quiz_id
	 */
	public function submitQuiz($user_id, $quiz_id){
		
		$submission = Submission::model()->find('user_id=:user_id AND quiz_id=:quiz_id', 
			array(
				':user_id' => $user_id,			
				':quiz_id' => $quiz_id,			
			)
		);

		try {
			if($submission != null){
				$submission->STATUS = Submission::SUBMITTED;
				$submission->save();
				
			} else {  
				throw new SubmittingUnstartedQuizException();
			}
		} catch (SubmittingUnstartedQuizException $e){
			return false;
		}
		
		return true;
	}
	
	/**
	 * gets status from user_id
	 * @param number $user_id
	 * @param number $quiz_id
	 * @return string char, Submission::status
	 */
	public function getStatusByUser($user_id, $quiz_id){
		$submission = Submission::model()->findByAttributes(array('USER_ID'=>$user_id, 'QUIZ_ID'=>$quiz_id));
		if($submission == null)
			return Submission::NOT_STARTED;
		return $submission->STATUS;
	}
	
	/**
	 * implementation of getStatusByUser
	 * @param number $user_id
	 * @param number $quiz_id
	 * @return boolean, is it submitted
	 */
	public function isSubmitted($user_id, $quiz_id){
		$status = Submission::getStatusByUser($user_id, $quiz_id);
		switch($status){
			case Submission::SUBMITTED:
			case Submission::FINISHED:
			case Submission::GRADED:
				return true;
		}
		return false;
		
	}
	
	/**
	 * gets the total results of people who are submitted and not for each quiz in a collection
	 * @param number $collection_id
	 * @return array of a hash array('submitted'=>\d, 'total_results'=>\d)
	 */
	public static function getResultTotals($collection_id){
				
		// just left joining the submissions on quizzes (so we get all quiz_ids and can set them to 0 in results)
		// note: resetScope was needed because defaultScope puts an ambiguous orderby in there (ORDER BY ASC ID)
		$quizzes = Quiz::model()->with(array(
			'submissions'=>array(
				'joinType'=>'LEFT JOIN'
			)
		))->resetScope()->findAllByAttributes(array('COLLECTION_ID'=>$collection_id));
		
		$results = array();
		foreach($quizzes as $quiz){
			if(!isset($results[$quiz->ID])){
				$results[$quiz->ID]['submitted'] = 0;
				$results[$quiz->ID]['total'] = 0;				
			}
			
			foreach($quiz->submissions as $submission){
				if($submission->STATUS == Submission::SUBMITTED)
					$results[$quiz->ID]['submitted']++;

				if($submission->STATUS != Submission::NOT_STARTED)
					$results[$quiz->ID]['total']++;
			}
		}
		return $results;

	}
	
}
