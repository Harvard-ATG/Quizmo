<?php
// Server-health script for quizmo. 
//
// This script observes the following conventions:
//
// - Returns "HTTP 200 OK" if the health check succeeds.
// - Returns "HTTP 503 Service Unavailable" if the health check fails. 
// - Accepts an optional query parameter "full" that will return the full 
//   results of the health check instead of just "OK" or "ERROR" (the default
//   output).
//
// Each health check is contained in a check_something() function 
// that does a report_error() if an error is detected. To disable a check, 
// comment out the run_check() line that calls the check. 
//
//------------------------------------------------------------------------

// global variables manipulated by check functions
$current_check = '__NONE__'; // holds the name of the current check 
$checks = array(); // holds list of strings that identify checks that have been performed
$errors = array(); // holds hash of errors that have occurred: check_name => error_value

//------------------------------------------------------------------------

// load Yii
function check_framework() {
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
		report_error($e->__toString());
	}
}

// check database
function check_database() {
	try {
		$config=dirname(__FILE__).'/protected/config/main.php';
		$config_arr = include($config);
		$connectionString = $config_arr['components']['db']['connectionString'];
		$username = $config_arr['components']['db']['username'];
		$password = $config_arr['components']['db']['password'];
		
		$connection = new CDbConnection($connectionString,$username,$password);
		$connection->active=true;
			
	} catch(Exception $e){
		report_error($e->__toString());
	}
}

// runs a single check
function run_check($check_function, $check_name='') {
	if(!$check_name) {
		$check_name = $check_function;
	}
	register_check($check_name);
	return call_user_func($check_function, $check_name);
}

// registers the check
function register_check($check_name) {
	global $checks, $current_check;
	$checks[] = $check_name;
    $current_check = $check_name;
}

// reports an error and logs it
function report_error($error_value) {
	global $errors, $current_check;
	$errors[$current_check] = $error_value;
	error_log("SERVER HEALTH CHECK ERROR: $error_value");
}

// displays the results
function show_results($full) {
	global $checks, $errors;

	if($full) {
		echo <<<EOF
		<html>
		<head>
		<style>
			table tr.error { color: red; }
			table tr.ok { color: green; }
			table td { vertical-align: top; padding: 4px 8px; } 
			table td:nth-child(1) { font-weight: bold; }
			table td:nth-child(2) { font-family: monospace; white-space: pre; }
		</style>
		</head>
		<body>
		<table>
EOF;
		foreach($checks as $check_name) {
			if(array_key_exists($check_name, $errors)) {
				$css = 'error';
				$error_value = $errors[$check_name];
			} else {
				$css = 'ok';
				$error_value = 'OK';
			}
			echo "<tr class=\"$css\"><td>$check_name</td><td>$error_value</td></tr>";
		}
		echo <<<EOF
		</table>
		</body>
		</html>
EOF;
	} else {
		if(empty($errors)) {
			echo("OK");
		} else {
			echo("ERROR");
		}
	}
}

//------------------------------------------------------------------------

// call the check functions
run_check('check_framework', 'Framework'); 
run_check('check_database', 'Database'); 

// set the output headers
header('Cache-Control: no-cache, must-revalidate');
header('Pragma: no-cache');
if(empty($errors)){
	header('Http/1.1 200 OK');
	header('Status: 200 OK');
} else {
	header('HTTP/1.1 503 Service Unavailable');
	header('Status: 503 Service Unavailable');
}

// show the results
show_results(isset($_GET['full']));
