<?php
/**
 * Allows to generate links using CHtml::link().
 *
 * Syntax:
 * {url url="/path/to/something"}
 *
 *
 * @param array $params
 * @param Smarty $smarty
 * @return string
 */
function smarty_function_url($params, &$smarty){

	$url = $params['url'];
	if(Yii::app()->params['authMethod'] == 'isites'){
		
		//$urlmanager = Yii::app()->getUrlManager();
		//$url = $urlmanager->createUrl($url);

		// don't put the SCRIPT_URI in there, full url fails
		//$url = $_SERVER['SCRIPT_URI'].$url;

		$url = Yii::app()->isitestool->url($url);

		
	}

    return $url;
}
