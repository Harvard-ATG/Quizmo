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
	//$question = "you put the {lime} in the {coconut} and {drink} it all up";
	
	preg_match_all("/\{[^}]*\}/", $question, $matches);
	foreach($matches as $val){
		foreach($val as $key => $match){
			error_log($match);
			$new_input = "<input class='input-small' type='text'/>";
			$question = preg_replace("/".addslashes($match)."/", $new_input, $question);
		}
		//error_log(var_export($match, 1));
		
	}
	

    return $question;
}
