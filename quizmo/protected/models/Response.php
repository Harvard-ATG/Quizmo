<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */


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
			array('SCORE_STATE', 'length', 'max'=>255),
			array('QUESTION_TYPE', 'length', 'max'=>1),
			array('RESPONSE', 'length', 'max'=>3900),
		//	array('DATE_MODIFIED', 'length', 'max'=>6),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			//array('ID, QUESTION_ID, QUESTION_TYPE, USER_ID, RESPONSE, SCORE_STATE, SCORE, DATE_MODIFIED, MODIFIED_BY', 'safe', 'on'=>'search'),
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
		//error_log("submitEssayQuestion");
		//error_log("$user_id, $question_id, $essay");
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
				
				$response->save(false);

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
				$response = null;
			}
			
			// have to get responses again after the delete
			$responses = Response::model()->findAll(
				'user_id=:user_id AND question_id=:question_id', 
				array(
					':user_id' => $user_id,			
					':question_id' => $question_id,			
				)
			);


			
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
		//error_log("getResults");

		// get identity
		$identity = IdentityFactory::getIdentity();
		
		$results = array();

		// get all users here
		//$users = UsersCollection::getUsers(Quiz::getCollectionId($quiz_id));
		$users = UsersCollection::getUsersAndPermissions(Quiz::getCollectionId($quiz_id));
		//error_log(var_export($users, 1));
		
		// then add them to the results array
		foreach($users as $user_id => $permission){
			if(!isset($results[$user_id])){
				$results[$user_id] = array('USER_ID'=>$user_id, 'permission'=>$permission);
			} else {
				$results[$user_id]['permission'] = $permission;
			}
		}
		
		// process results adding in people data
		foreach($results as $key => $value){
			$user_id = $key;
			$name = User::getName($user_id);
			$status = Submission::getStatusByUser($user_id, $quiz_id);
			$score = Response::getTotalScoreByUser($user_id, $quiz_id);
			$results[$key]['name'] = $name;
			//$results[$key]['status'] = $status;
			// submission
			// const NOT_STARTED = 'N'; // this one may never be used
			// const STARTED = 'U';
			// const UNFINISHED = 'U';
			// const SUBMITTED = 'S';
			// const FINISHED = 'F';
			// const GRADED = 'F';
			switch($status){
				case Submission::NOT_STARTED:
					$results[$key]['status'] = "Not Started";
					break;
				case Submission::STARTED:
					$results[$key]['status'] = "Started / Unfinished";
					break;
				case Submission::FINISHED:
					$results[$key]['status'] = "Finished";
					break;
				case Submission::SUBMITTED:
					$results[$key]['status'] = "Submitted";
					break;
				default:
					$results[$key]['status'] = "Unknown";
					break;
				
			}
			$results[$key]['score'] = $score;
			// call identity getAllUsers method
			$photo_url = $identity->getPhotoUrl($user_id, 50);
			$results[$key]['photo_url'] = $photo_url;
			
		}

		return $results;
	}

	/**
	 * gets an array of results for a quiz
	 * @todo trim down, probably dont need to be fetching all responses for this...
	 * @param integer $quiz_id
	 * @return array
	 */
	public function getAllResults($quiz_id){
		//error_log("getAllResults");

		// get normal results data
		$results = Response::getResults($quiz_id);
		
		// now we need all question - answer - response data
		foreach($results as $user_id => $result){
			$results[$user_id]['questions'] = Question::getQuestionViewsByQuizIdUserId($quiz_id, $user_id);
		}
		//error_log(var_export($results, 1));

		// first get all the questions for the quiz
		// with all of the answers
		//$question_ids = Quiz::getQuestionIds($quiz_id);
		
		
		// then responses for all the questions
		//if($question_id_string == '')
		//	return array();
		//$responses = Response::model()->findAll(
		//	"question_id in ($question_id_string)"
		//);
		
		//$results = array();
		// run through them, add to the results array
		// turn the response into an array so I can manipulate it
		/*
		foreach($responses as $response){
			$responseArr = array();
			$results[$response->USER_ID] = array();
			foreach($response as $key => $value){
				$responseArr[$key] = $value;
			}
			
			//error_log(var_export($responseArr, 1));
			
			array_push($results[$response->USER_ID], $responseArr);

		}
		*/
		
		//error_log(var_export($results, 1));


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
	
	/**
	 * checks if a user got an answer correct.
	 * this only works for MC, TF, MS... 
	 * @param number $user_id
	 * @param number $answer_id
	 * @return boolean
	 */
	public function isAnswerSelected($user_id, $answer_id){
		// get answer
		$answer = Answer::model()->findByPk($answer_id);
		
		// get responses
		$responses = Response::model()->findAllByAttributes(array('USER_ID'=>$user_id, 'QUESTION_ID'=>$answer->QUESTION_ID));
		
		foreach($responses as $response){
			if($response->RESPONSE == $answer_id){
				return true;
			}
		}
		return false;
	}

	/**
	 * gets the score
	 * @param number $response_id
	 * @return number $score
	 */
	public function getScore($response_id){
		$response = Response::model()->findByPk($response_id);
		return $response->SCORE;

	}
	
	/**
	 * grades response, sets the score
	 * @param number $response_id
	 * @param number $score
	 * @return boolean
	 */
	public function setScore($response_id, $score){
		// get response
		$response = Response::model()->findByPk($response_id);
		// set SCORE
		$response->SCORE = $score;
		// set SCORE_STATE
		$response->SCORE_STATE = Response::MANUAL_SCORED;
		// save
		return $response->save(false);
	}
	
	/**
	 * grades an entire quiz based on answers
	 * this needs to run through every question, every answer, every response and match based on Answer - Response
	 * @param number $user_id
	 * @param number $quiz_id
	 * @return boolean
	 */
	public function gradeQuiz($user_id, $quiz_id){
		//$questions = Question::model()->with('responses', 'answers')->findAllByAttributes(array('QUIZ_ID'=>$quiz_id);
		// a huge query is very inefficient, and will not scale appropriately
		
		$question_ids = Quiz::getQuestionIds($quiz_id);		// this is a hash that has question_id as the key and question->points as the value
		$question_points = Quiz::getQuestionPoints($quiz_id);
		$question_ids_string = join(",", $question_ids);
		$responses = Response::model()->findAllByAttributes(array('QUESTION_ID'=>$question_ids, 'USER_ID'=>$user_id));
		$answers = Answer::model()->findAll("QUESTION_ID IN ($question_ids_string)");
		
		$last_question_id = '';
		foreach($responses as $response){

			$is_new_question = false;
			if($last_question_id != $response->QUESTION_ID){
				$response_array = array();
				$answer_array = array();
				$is_new_question = true;
				$done = false;
				$correct = false;
			}

			$last_question_id = $response->QUESTION_ID;
			$last_response_id = '';
			$is_new_response = true;
			
			
			foreach($answers as $answer){
				if($answer->QUESTION_ID == $response->QUESTION_ID){
					// now we have a matching response and answer
					
					$is_new_response = false;
					if($last_response_id != $response->ID){
						$is_new_response = true;
					}
					$last_response_id = $response->ID;
					
					
					switch($response->QUESTION_TYPE){
						case Question::MULTIPLE_CHOICE:
						case Question::TRUE_FALSE:
							// we have to check if the response->RESPONSE matches the answer->ID
							if($response->RESPONSE == $answer->ID && $answer->IS_CORRECT == 1){
								// then we have a correct response
								Response::setScore($response->ID, $question_points[$response->QUESTION_ID]);
							}
						break;
						case Question::NUMERICAL:
							// have to take into account tolerance
							$upper = $answer->ANSWER + $answer->TOLERANCE;
							$lower = $answer->ANSWER - $answer->TOLERANCE;
							if($response->RESPONSE <= $upper && $response->RESPONSE >= $lower){
								Response::setScore($response->ID, $question_points[$response->QUESTION_ID]);
							}
						break;
						case Question::MULTIPLE_SELECTION:
								
							if($is_new_question){
								if($answer->IS_CORRECT)
									array_push($answer_array, $answer->ID);
							}
							
							if($is_new_response){
								array_push($response_array, $response->RESPONSE);
							}
														
							if(implode("", $response_array) == implode("", $answer_array)){
								if(!$correct)
									Response::setScore($response->ID, $question_points[$response->QUESTION_ID]);
								$correct = true;
							} else {
								Response::setScore($response->ID, 0);
								$correct = false;
							}							
							
						break;	
						case Question::FILLIN:
							if($is_new_question){
								array_push($answer_array, $answer->ANSWER);
							}
							if($is_new_response){
								array_push($response_array, $response->RESPONSE);
							}
							
							// so we need to run through the responses and match them
							// each individually with what should be the corresponding answer
							$correct = false;
							for($i = 0; $i < sizeof($response_array); $i++){
								if(isset($response_array[$i]) && isset($answer_array[$i])){
									if($answer->IS_CASE_SENSITIVE != 1){
										$response_array[$i] = strtolower($response_array[$i]);
										$answer_array[$i] = strtolower($answer_array[$i]);
									}
										
									$acceptable_answers = explode("|", $answer_array[$i]);
									$correct = false;
									foreach($acceptable_answers as $acceptable_answer){
										if($response_array[$i] == $acceptable_answer){
											$correct = true;
										} 										
									}									
									
									if($correct == false){
										break;
									}
									
								} else {
									$correct = false;
									break;
								}
							}
							
							/*							
							// this creates a string consisting of all the responses put together
							$response_string = implode("", $response_array);
							// this creates a string consisting of all of the answers put together
							// TODO: create multiple answer strings based on pipe answers...
							// in case of a pipe answer, this is not checking it appropriately
							$answer_string = implode("", $answer_array);
							
							if($answer->IS_CASE_SENSITIVE != 1){
								$response_string = strtolower($response_string);
								$answer_string = strtolower($answer_string);
							}
							
							// get all the answers seperated by |
							$answerArr = explode("|", $answer_string);
							
							foreach($answerArr as $answer){
								if($response_string == $answer){
									$correct = true;
									break;
								} 
								$correct = false;
							}
							*/
							
							if($correct)
								Response::setScore($response->ID, $question_points[$response->QUESTION_ID]);
							else
								Response::setScore($response->ID, 0);
								
							
						break;
						
					}
					

					// do not break;
					// MS and fillin can have multiple responses with the same question_id
					continue;
				}
				
			}
			
		}
		
		
		if($responses == null)
			return false;
		else
			return true;
	}
	
	/**
	 * gets a hash for question_ids and boolean answered/notanswered
	 * @param number $quiz_id
	 * @param number $user_id
	 * @return hash
	 */
	function getQuestionsAnsweredByQuizIdUserId($quiz_id, $user_id){
		$question_ids = Quiz::getQuestionIds($quiz_id);		// this is a hash that has question_id as the key and question->points as the value
		$question_ids_string = join(",", $question_ids);
		$responses = Response::model()->findAllByAttributes(array('QUESTION_ID'=>$question_ids, 'USER_ID'=>$user_id));
		$answered_hash = array();
		foreach($question_ids as $question_id){
			$answered_hash[$question_id] = false;
			foreach($responses as $response){
				if($response->QUESTION_ID == $question_id){
					$answered_hash[$question_id] = true;			
				}
			}
		}
		return $answered_hash;
		
	}
	
	/**
	 * deletes all responses for a user given a quiz_id
	 * @param number $quiz_id
	 * @param number $user_id
	 * @return boolean
	 */
	static function deleteByQuizIdUserId($quiz_id, $user_id){
		if(Response::model()->deleteAllByAttributes(array('USER_ID'=>$user_id, 'QUESTION_ID'=>Quiz::getQuestionIds($quiz_id)))){
			Submission::model()->deleteAllByAttributes(array('USER_ID'=>$user_id, 'QUIZ_ID'=>$quiz_id));
			return true;
		}
		else {
			return false;
		}
	}
	
}
