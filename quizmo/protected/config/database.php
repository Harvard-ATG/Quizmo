<?php

return array(
	'components'=>array(
		
		// uncomment the following to use an Oracle database
		/*
		'db'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'oci:dbname=my_host;charset=UTF8',
			//'attributes' => array(PDO::ATTR_CASE => PDO::CASE_LOWER),
			'username' => 'my_username',
			'password' => 'my_password',
			//'schemaCachingDuration' => 1000000,
		),
		*/
		
		'db'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=quizmo_dev',
			'emulatePrepare' => true,
			'username' => 'quizmo_dev',
			'password' => 'quizmo_dev',
			'charset' => 'utf8',
			'enableProfiling' => true,
			'enableParamLogging' => true
		),
				
	),
);


?>