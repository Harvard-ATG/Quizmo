<?php
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
	//$question = "you put the {lime} in the {coconut} and {drink} it all up";
	//$responses = array(array(response=>lime), array(response=>coconut), array(response=>drink))
	$disabled = '';
	if(isset($params['disabled'])){
		$disabled = " disabled ";
	}
	
	preg_match_all("/\{[^}]*\}/", $question, $matches);
	$responses_index = 0;
	foreach($matches as $val){
		foreach($val as $key => $match){
			//error_log($match);
			//if($responses == null){
			if(!isset($responses[$responses_index])){
				$new_input = "<input class='input-small fillin-text' type='text'/>";				
			} else {
				//error_log("$response...");
				$response = $responses[$responses_index]['response'];
				$responses_index++;
				$new_input = "<input class='input-small fillin-text $disabled' type='text' value='$response' $disabled/>";
			}
			$question = preg_replace("/".addslashes($match)."/", $new_input, $question);
		}
		//error_log(var_export($match, 1));
	}
	

    return $question;
}
