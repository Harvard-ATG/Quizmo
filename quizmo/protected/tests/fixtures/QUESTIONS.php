<?php
/**
 * The fixtures for table "Questions".
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

return array(
	
	'question1' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'M',
		'TITLE' => 'Multiple Choice Question 1',
		'BODY' => "Pick a number, any number",
		'QUESTION_ORDER' => 1,
		'POINTS' => '',
		'FEEDBACK' => '',
		'DELETED' => 0,
	),
	'question2' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'T',
		'TITLE' => 'True False Question 2',
		'BODY' => "True or False",
		'QUESTION_ORDER' => 2,
		'POINTS' => '',
		'FEEDBACK' => '',
		'DELETED' => 0,
	),
	'question3' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'N',
		'TITLE' => 'Numerical Question 3',
		'BODY' => "Pick a number, any number",
		'QUESTION_ORDER' => 3,
		'POINTS' => '5',
		'FEEDBACK' => 'question 3 feedback',
		'DELETED' => 0,
	),
	'question4' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'N',
		'TITLE' => 'Numerical Question 4',
		'BODY' => "Pick a number, any number",
		'QUESTION_ORDER' => 4,
		'POINTS' => '10',
		'FEEDBACK' => 'question 4 feedback',
		'DELETED' => 0,
	),
	'question5' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'E',
		'TITLE' => 'Essay Question 5',
		'BODY' => "Talk about something",
		'QUESTION_ORDER' => 5,
		'POINTS' => '',
		'FEEDBACK' => 'question 5 feedback',
		'DELETED' => 0,
	),
	'question6' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'S',
		'TITLE' => 'Multiple Selection Question 6',
		'BODY' => "Select A and B",
		'QUESTION_ORDER' => 6,
		'POINTS' => '',
		'FEEDBACK' => 'question 6 feedback',
		'DELETED' => 0,
	),
	'question7' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'E',
		'TITLE' => 'Essay Question 7',
		'BODY' => "Talk about something",
		'QUESTION_ORDER' => 7,
		'POINTS' => '',
		'FEEDBACK' => 'question 7 feedback',
		'DELETED' => 0,
	),
	'question8' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'F',
		'TITLE' => 'Fill in Question 8',
		'BODY' => "You put the {lime} in the {Coconut} and {drink} it all up",
		'QUESTION_ORDER' => 8,
		'POINTS' => '20',
		'FEEDBACK' => 'question 8 feedback',
		'DELETED' => 0,
	),
	
	
);


?>
