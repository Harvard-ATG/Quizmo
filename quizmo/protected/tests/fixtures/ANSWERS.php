<?php
/**
 * The fixtures for table "Answers".
 *
 * The first 3 are just Multiple Choice Answers
 *
 * The followings are the available columns in table 'Answers':
 * @property integer $id
 * @property integer $question_id
 * @property string $question_type
 * @property integer $textarea_rows
 * @property string $answer
 * @property integer $is_case_sensitive
 * @property integer $answer_order
 * @property integer $is_correct
 * @property double $tolerance
 */

return array(
	
	'answer1' => array(
		'QUESTION_ID' => '1',
		'QUESTION_TYPE' => 'M',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "A",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 1,
		'IS_CORRECT' => 1,
		'TOLERANCE' => '',
	),
	'answer2' => array(
		'QUESTION_ID' => '1',
		'QUESTION_TYPE' => 'M',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "B",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 2,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '',
	),
	'answer3' => array(
		'QUESTION_ID' => '1',
		'QUESTION_TYPE' => 'M',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "C",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 3,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '',
	),
	'answer4' => array(
		'QUESTION_ID' => '2',
		'QUESTION_TYPE' => 'T',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "True",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 1,
		'IS_CORRECT' => 1,
		'TOLERANCE' => '',
	),
	'answer5' => array(
		'QUESTION_ID' => '2',
		'QUESTION_TYPE' => 'T',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "False",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 2,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '',
	),
	'answer6' => array(
		'QUESTION_ID' => '3',
		'QUESTION_TYPE' => 'N',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "10",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 1,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '3',
	),
	'answer7' => array(
		'QUESTION_ID' => '4',
		'QUESTION_TYPE' => 'N',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "1",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 1,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '.5',
	),
	'answer8' => array(
		'QUESTION_ID' => '5',
		'QUESTION_TYPE' => 'E',
		'TEXTAREA_ROWS' => '10',
		'ANSWER' => "",
		'IS_CASE_SENSITIVE' => '0',
		'ANSWER_ORDER' => 1,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '',
	),
	'answer9' => array(
		'QUESTION_ID' => '6',
		'QUESTION_TYPE' => 'S',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "A",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 1,
		'IS_CORRECT' => 1,
		'TOLERANCE' => '',
	),
	'answer10' => array(
		'QUESTION_ID' => '6',
		'QUESTION_TYPE' => 'S',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "B",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 2,
		'IS_CORRECT' => 1,
		'TOLERANCE' => '',
	),
	'answer11' => array(
		'QUESTION_ID' => '6',
		'QUESTION_TYPE' => 'S',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "C",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 3,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '',
	),
	'answer12' => array(
		'QUESTION_ID' => '7',
		'QUESTION_TYPE' => 'E',
		'TEXTAREA_ROWS' => '10',
		'ANSWER' => "",
		'IS_CASE_SENSITIVE' => '0',
		'ANSWER_ORDER' => 1,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '',
	),
	'answer13' => array(
		'QUESTION_ID' => '8',
		'QUESTION_TYPE' => 'F',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "",
		'IS_CASE_SENSITIVE' => 0,
		'ANSWER_ORDER' => 1,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '',
	),
	
	
	
);


?>
