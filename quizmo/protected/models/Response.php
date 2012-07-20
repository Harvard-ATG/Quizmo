<?php

/**
 * self explanitory exception
 */
class IncorrectQuestionTypeException extends Exception { }

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
class Response extends QActiveRecord
{
	
	const NOT_SCORED = 'N';
	const AUTO_SCORED = 'A';
	const MANUAL_SCORED = 'M';
	
	public $sequenceName = 'RESPONSES_SEQ';
	
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
		return 'RESPONSES';
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
	
	/**
	 * submits an essay question
	 * @param number $user_id
	 * @param number $question_id
	 * @param string $essay
	 * @param number $modified_by should be user_id if not specified
	 * @return boolean
	 */
	public function submitEssayQuestion($user_id, $question_id, $essay, $modified_by=''){
		if($modified_by == '')
			$modified_by = $user_id;
			
		$response = Response::model()->find('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);

		try {
			if($response == null){
				// create new
				$response = new Response;

				// NOTE: if you are doing auto-increment, this->ID will be overwritten with whatever
				//    the sequence is at at the save()

				$response->USER_ID = $user_id;
				$response->QUESTION_ID = $question_id;
				$response->QUESTION_TYPE = Question::ESSAY;
				$response->RESPONSE = $essay;
				$response->SCORE_STATE = Response::NOT_SCORED;
				$resposne->MODIFIED_BY = $modified_by;
				
				$response->save();
				
			} else {  
				//edit existing

				$response->QUESTION_TYPE = Question::ESSAY;
				$response->RESPONSE = $essay;
				$response->SCORE_STATE = Response::NOT_SCORED;
				$resposne->MODIFIED_BY = $modified_by;
				
				$response->save();

			}
		} catch (Exception $e){
			error_log($e->getTraceAsString());
			return false;
		}
		
		return true;
		
	}
	
	/**
	 * submits a numerical question
	 * @param number $user_id
	 * @param number $question_id
	 * @param number $number
	 * @param number $modified_by should be user_id if not specified
	 * @return boolean
	 */
	public function submitNumericalQuestion($user_id, $question_id, $number, $modified_by=''){
		if($modified_by == '')
			$modified_by = $user_id;
			
		$response = Response::model()->find('user_id=:user_id AND question_id=:question_id', 
			array(
				':user_id' => $user_id,			
				':question_id' => $question_id,			
			)
		);

		try {
			if($response == null){
				// create new
				$response = new Response;

				// NOTE: if you are doing auto-increment, this->ID will be overwritten with whatever
				//    the sequence is at at the save()

				$response->USER_ID = $user_id;
				$response->QUESTION_ID = $question_id;
				$response->QUESTION_TYPE = Question::NUMERICAL;
				$response->RESPONSE = $number;
				$response->SCORE_STATE = Response::NOT_SCORED;
				$resposne->MODIFIED_BY = $modified_by;
				
				$response->save();
				
			} else {  
				//edit existing

				$response->QUESTION_TYPE = Question::NUMERICAL;
				$response->RESPONSE = $number;
				$response->SCORE_STATE = Response::NOT_SCORED;
				$resposne->MODIFIED_BY = $modified_by;
				
				$response->save();

			}
		} catch (Exception $e){
			error_log($e->getTraceAsString());
			return false;
		}
		
		return true;
		
	}

	/**
	 * submits a multiple selection question
	 * @param number $user_id
	 * @param number $question_id
	 * @param array $answers an array of answer_ids
	 * @param number $modified_by should be user_id if not specified
	 * @return boolean
	 */
	public function submitMultipleSelectionQuestion($user_id, $question_id, $answers, $modified_by=''){
		if($modified_by == '')
			$modified_by = $user_id;

		try {
			
			// remove all previous answers for this question
			$responses = Response::model()->findAll(
				'user_id=:user_id AND question_id=:question_id', 
				array(
					':user_id' => $user_id,			
					':question_id' => $question_id,			
				)
			);
			foreach($responses as $response){
				$response->delete();
			}
			

			// go through each $answers as $answer_id and add it
			foreach($answers as $answer_id){
				$response = Response::model()->find(
					'user_id=:user_id AND question_id=:question_id AND response=:answer_id', 
					array(
						':user_id' => $user_id,			
						':question_id' => $question_id,			
						':answer_id' => $answer_id,			
					)
				);
			
				if($responses == null){
					// create new
					$response = new Response;

					$response->USER_ID = $user_id;
					$response->QUESTION_ID = $question_id;
					$response->QUESTION_TYPE = Question::MULTIPLE_SELECTION;
					$response->RESPONSE = $answer_id;
					$response->SCORE_STATE = Response::NOT_SCORED;
					$resposne->MODIFIED_BY = $modified_by;
				
					$response->save();
				
				} else {  
					// edit existing
					// not needed

				}
			

			}
		} catch (Exception $e){
			error_log($e->getTraceAsString());
			return false;
		}
		
		return true;
		
	}

	/**
	 * submits a multiple choice question
	 * @param number $user_id
	 * @param string $question_type
	 * @param number $question_id
	 * @param array $answers an array of answer_ids
	 * @param number $modified_by should be user_id if not specified
	 * @return boolean
	 */
	public function submitMultipleChoiceQuestion($user_id, $question_type, $question_id, $answer_id, $modified_by=''){
		if($modified_by == '')
			$modified_by = $user_id;

		try {
			
			// remove all previous answers for this question
			$responses = Response::model()->findAll(
				'user_id=:user_id AND question_id=:question_id', 
				array(
					':user_id' => $user_id,			
					':question_id' => $question_id,			
				)
			);
			foreach($responses as $response){
				$response->delete();
			}
			

			$response = Response::model()->find(
				'user_id=:user_id AND question_id=:question_id', 
				array(
					':user_id' => $user_id,			
					':question_id' => $question_id,			
				)
			);
			
			if($response == null){
				// create new
				$response = new Response;

				$response->USER_ID = $user_id;
				$response->QUESTION_ID = $question_id;
				$response->QUESTION_TYPE = $question_type;
				$response->RESPONSE = $answer_id;
				$response->SCORE_STATE = Response::NOT_SCORED;
				$resposne->MODIFIED_BY = $modified_by;
				
				$response->save();
				
			} else {  
				// edit existing
				// not needed


			}

		} catch (Exception $e){
			error_log($e->getTraceAsString());
			return false;
		}
		
		return true;
		
	}

	/**
	 * submits a multiple choice question
	 * @param number $user_id
	 * @param number $question_id
	 * @param array $answers an array of string answers
	 * @param number $modified_by should be user_id if not specified
	 * @return boolean
	 */
	public function submitFillinQuestion($user_id, $question_id, $answers, $modified_by=''){
		if($modified_by == '')
			$modified_by = $user_id;

		try {
			
			// remove all previous answers for this question
			$responses = Response::model()->findAll(
				'user_id=:user_id AND question_id=:question_id', 
				array(
					':user_id' => $user_id,			
					':question_id' => $question_id,			
				)
			);
			foreach($responses as $response){
				$response->delete();
			}
			

			// go through each $answers as $answer_id and add it
			foreach($answers as $answer){
				// this part isn't really necessary...
				$response = Response::model()->find(
					'user_id=:user_id AND question_id=:question_id AND response=:answer', 
					array(
						':user_id' => $user_id,			
						':question_id' => $question_id,			
						':answer' => $answer,			
					)
				);
				if($response == null){
					// create new
					$response = new Response;

					$response->USER_ID = $user_id;
					$response->QUESTION_ID = $question_id;
					$response->QUESTION_TYPE = Question::FILLIN;
					$response->RESPONSE = $answer;
					$response->SCORE_STATE = Response::NOT_SCORED;
					$resposne->MODIFIED_BY = $modified_by;
				
					$response->save();

				} else {  
					// edit existing
					// not needed
				}
			}
		} catch (Exception $e){
			error_log($e->getTraceAsString());
			return false;
		}
		
		return true;

	}
	
	/**
	 * gets an array of results for a quiz
	 * @todo trim down, probably dont need to be fetching all responses for this...
	 * @param integer $quiz_id
	 * @return array
	 */
	public function getResults($quiz_id){

		// first get all the questions for the quiz
		$question_ids = Quiz::getQuestionIds($quiz_id);
		
		// turn the array into a string
		$question_id_string = implode(", ", $question_ids);
		
		// then responses for all the questions
		$responses = Response::model()->findAll(
			"question_id in ($question_id_string)"
		);
		
		$results = array();
		// run through them, add to the results array
		foreach($responses as $response){
			
			$results[$response->USER_ID] = array();
			array_push($results[$response->USER_ID], $response);

		}
		
		// process results adding in people data
		foreach($results as $key => $value){
			$user_id = $key;
			$name = User::getName($user_id);
			$status = Submission::getStatusByUser($user_id, $quiz_id);
			$score = Response::getTotalScoreByUser($user_id, $quiz_id);
			$results[$key]['name'] = $name;
			$results[$key]['status'] = $status;
			$results[$key]['score'] = $score;
		}

		return $results;
	}
	
	/**
	 * gets the total score by the user... 
	 * @param number $user_id
	 * @param number $quiz_id
	 * @return number
	 */
	public function getTotalScoreByUser($user_id, $quiz_id){
		$responses = Response::model()->findAllByAttributes(array('USER_ID'=>$user_id));
		$question_ids = Quiz::getQuestionIds($quiz_id);
		$score = 0;
		foreach($responses as $response){
			if(in_array($response->QUESTION_ID, $question_ids)){
				$score += $response->SCORE;				
			}
		}
		return $score;

	}
	
	/**
	 * checks if a user got an answer correct.
	 * this only works for MC, TF, MS... 
	 * @param number $user_id
	 * @param number $answer_id
	 * @return boolean
	 */
	public function isAnswerCorrect($user_id, $answer_id){
		// get answer
		$answer = Answer::model()->findByPk($answer_id);
		if($answer->IS_CORRECT != 1)
			return false;

		// get responses
		$responses = Response::model()->findAllByAttributes(array('USER_ID'=>$user_id, 'QUESTION_ID'=>$answer->QUESTION_ID));
		
		// check if it's correct
		foreach($responses as $response){
			if($response->RESPONSE == $answer_id){
				return true;
			}
		}
		return false;
	}
	
	
}