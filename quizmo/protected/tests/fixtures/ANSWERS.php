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
	
	'answer0' => array(
		'QUESTION_ID' => '1',
		'QUESTION_TYPE' => 'M',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "This is a multiple choice answer",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 1,
		'IS_CORRECT' => 1,
		'TOLERANCE' => '',
	),
	'answer1' => array(
		'QUESTION_ID' => '1',
		'QUESTION_TYPE' => 'M',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "This is a multiple choice answer",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 2,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '',
	),
	'answer2' => array(
		'QUESTION_ID' => '1',
		'QUESTION_TYPE' => 'M',
		'TEXTAREA_ROWS' => '',
		'ANSWER' => "This is a multiple choice answer",
		'IS_CASE_SENSITIVE' => '',
		'ANSWER_ORDER' => 3,
		'IS_CORRECT' => 0,
		'TOLERANCE' => '',
	),
	
	
);


?>
