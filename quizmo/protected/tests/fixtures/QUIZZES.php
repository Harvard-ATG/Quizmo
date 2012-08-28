<?php
/**
 * These are the fixtures for table "Quizzes".
 *
 * The followings are the available columns in table 'Quizzes':
 * @property integer $ID
 * @property integer $COLLECTION_ID
 * @property string $TITLE
 * @property string $DESCRIPTION
 * @property integer $VISIBILITY
 * @property string $STATE
 * @property integer $SHOW_FEEDBACK
 * @property string $START_DATE
 * @property string $END_DATE
 * @property string $DATE_MODIFIED
 * @property integer $DELETED
 */
return array(
	
	'quiz0' => array(
		'COLLECTION_ID' => '1',
		'TITLE' => 'dev quiz prime',
		'VISIBILITY' => 1,
		'STATE' => 'O',
		'SHOW_FEEDBACK' => 0,
		'START_DATE' => '',
		'END_DATE' => '',
		'DATE_MODIFIED' => '',
		'DELETED' => 0,
		'DESCRIPTION' => "",
	),
	'quiz1' => array(
		'COLLECTION_ID' => '1',
		'TITLE' => 'First Quiz',
		'VISIBILITY' => 1,
		'STATE' => 'O',
		'SHOW_FEEDBACK' => 0,
		'START_DATE' => '',
		'END_DATE' => '',
		'DATE_MODIFIED' => '',
		'DELETED' => 0,
		'DESCRIPTION' => "This is the first quiz, it's really exciting so the description is really long!",
	),
	'quiz2' => array(
		'COLLECTION_ID' => '1',
		'TITLE' => 'Second Quiz',
		'VISIBILITY' => 1,
		'STATE' => 'C',
		'SHOW_FEEDBACK' => 0,
		'START_DATE' => '',
		'END_DATE' => '',
		'DATE_MODIFIED' => '',
		'DELETED' => 0,
		'DESCRIPTION' => "Less exciting now",
	),
	'quiz3' => array(
		'COLLECTION_ID' => '1',
		'TITLE' => 'Third Quiz',
		'VISIBILITY' => 1,
		'STATE' => 'O',
		'SHOW_FEEDBACK' => 0,
		'START_DATE' => '',
		'END_DATE' => '',
		'DATE_MODIFIED' => '',
		'DELETED' => 0,
		'DESCRIPTION' => "!",
	),
	'quiz4' => array(
		'COLLECTION_ID' => '2',
		'TITLE' => 'Fourth Quiz',
		'VISIBILITY' => 1,
		'STATE' => 'S',
		'SHOW_FEEDBACK' => 0,
		'START_DATE' => '01/01/2012',
		'END_DATE' => '01/01/2013',
		'DATE_MODIFIED' => '',
		'DELETED' => 0,
		'DESCRIPTION' => "",
	),
	'quiz5' => array(
		'COLLECTION_ID' => '2',
		'TITLE' => 'Fifth Quiz',
		'VISIBILITY' => 1,
		'STATE' => 'S',
		'SHOW_FEEDBACK' => 0,
		'START_DATE' => '01/01/2012',
		'END_DATE' => '01/10/2012',
		'DATE_MODIFIED' => '',
		'DELETED' => 0,
		'DESCRIPTION' => "",
	),
	
	
);


?>
