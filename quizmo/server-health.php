<?php

// hash of errors
$errors = array();

// load Yii
try {
	$yii=dirname(__FILE__).'/../yii/framework/yii.php';
	$config=dirname(__FILE__).'/protected/config/main.php';
	$deploy_stage = dirname(__FILE__).'/protected/config/deploy_stage.php';

	// remove the following lines when in production mode
	if($deploy_stage == 'dev')
		defined('YII_DEBUG') or define('YII_DEBUG',true);

	// specify how many levels of call stack should be shown in each log message
	defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
 
	require_once($yii);
} catch(Exception $e){
	$errors['Framework'] = $e->__toString();
}

// check database
try {
	$config_arr = include($config);
	$connectionString = $config_arr['components']['db']['connectionString'];
	$username = $config_arr['components']['db']['username'];
	$password = $config_arr['components']['db']['password'];
	
	$connection = new CDbConnection($connectionString,$username,$password);
	$connection->active=true;
		
} catch(Exception $e){
	$errors['Database'] = $e->__toString();
}


if(empty($errors)){
	echo("OK");
} else {
	if(isset($_REQUEST['full'])){
		echo <<<EOF
		<html>
		<body>
		<table>
EOF;
		foreach($errors as $error_key => $error_value){
			echo "<tr><td>$error_key</td><td>$error_value</td></tr>";
		}
		echo <<<EOF
		</table>
		</body>
		</html>
EOF;
		
	} else {
		echo("ERROR");
	}
}

	
?>
