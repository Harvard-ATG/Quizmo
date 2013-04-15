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
 * @property integer $sort_order
 * @property integer $points
 * @property string $feedback
 * @property integer $deleted
 */

return array(
	
	'question1' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'M',
		'TITLE' => 'Multiple Choice Question 1',
		'SORT_ORDER' => 1,
		'POINTS' => '1',
		'DELETED' => 0,
		'BODY' => "Pick a number, any number",
		'FEEDBACK' => '',
	),
	'question2' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'T',
		'TITLE' => 'True False Question 2',
		'SORT_ORDER' => 2,
		'POINTS' => '2',
		'DELETED' => 0,
		'BODY' => "True or False",
		'FEEDBACK' => '',
	),
	'question3' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'N',
		'TITLE' => 'Numerical Question 3',
		'SORT_ORDER' => 3,
		'POINTS' => '3',
		'DELETED' => 0,
		'BODY' => "Pick a number, any number",
		'FEEDBACK' => 'question 3 feedback',
	),
	'question4' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'N',
		'TITLE' => 'Numerical Question 4',
		'SORT_ORDER' => 4,
		'POINTS' => '4',
		'DELETED' => 0,
		'BODY' => "Pick a number, any number",
		'FEEDBACK' => 'question 4 feedback',
	),
	'question5' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'E',
		'TITLE' => 'Essay Question 5',
		'SORT_ORDER' => 5,
		'POINTS' => '5',
		'DELETED' => 0,
		'BODY' => "Talk about something",
		'FEEDBACK' => 'question 5 feedback',
	),
	'question6' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'S',
		'TITLE' => 'Multiple Selection Question 6',
		'SORT_ORDER' => 6,
		'POINTS' => '6',
		'DELETED' => 0,
		'BODY' => "Select A and B",
		'FEEDBACK' => 'question 6 feedback',
	),
	'question7' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'E',
		'TITLE' => 'Essay Question 7',
		'SORT_ORDER' => 7,
		'POINTS' => '7',
		'DELETED' => 0,
		'BODY' => "Talk about something",
		'FEEDBACK' => 'question 7 feedback',
	),
	'question8' => array(
		'QUIZ_ID' => '1',
		'QUESTION_TYPE' => 'F',
		'TITLE' => 'Fill in Question 8',
		'SORT_ORDER' => 8,
		'POINTS' => '8',
		'DELETED' => 0,
		'BODY' => "You put the {lime|lemon} in the {Coconut} and {drink|eat} it all up",
		'FEEDBACK' => 'question 8 feedback',
	),
	
	
);


?>
