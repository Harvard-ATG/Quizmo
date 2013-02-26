<?php
/**
 * @copyright Copyright (c) 2012 The President and Fellows of Harvard College
 * @license Use of this source code is governed by the LICENSE file found in the root of this project.
 */

/**
 * creates the view string for fillin questions.  includes the input text fields
 *
 * Syntax:
 * {fillin question="roses are {red} violets are {blue}"}
 *
 *
 * @param array $params
 * @param Smarty $smarty
 * @return string
 */
function smarty_function_fillin($params, &$smarty){

	//error_log("fillin...");
	$question = $params['question'];
	$responses = null;
	if(isset($params['responses']))
		$responses = $params['responses'];
	$disabled = '';
	if(isset($params['disabled'])){
		$disabled = ' disabled="disabled" ';
	}
	
	preg_match_all("/\{[^}]*\}/", $question, $matches);
	$responses_index = 0;
	foreach($matches as $val){
		foreach($val as $key => $match){
			//error_log($match);
			if(!isset($responses[$responses_index])){
				$new_input = "<input class='input-small fillin-text' type='text' $disabled/>";				
			} else {
				$response = $responses[$responses_index]['response'];
				$responses_index++;
				$new_input = "<input class='input-small fillin-text' type='text' value='$response' $disabled/>";
			}
			// if the pipe is left in, this preg_replace matches more times than we want because of the OR in the match... 
			$question = preg_replace("/".preg_quote($match)."/", $new_input, $question);
		}
	}
	
    return $question;
}
