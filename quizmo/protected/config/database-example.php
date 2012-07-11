<?php

return array(
	'components'=>array(

		// uncomment the following to use an Oracle database
		'db'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'oci:dbname=icgdbdev.fas.harvard.edu;charset=UTF8',
			'username' => 'quizmo_dev',
			'password' => 'YcKx_2xCbm',
			//'schemaCachingDuration' => 1000000,
		),
<<<<<<< HEAD
		*/

=======
		
		
		/*
>>>>>>> 3f5ad3577ebe3f5c3c93c7f93eb9dc74c692ac1d
		'db'=>array(
			'class' => 'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=quizmo_dev',
			'emulatePrepare' => true,
			'username' => 'quizmo_dev',
			'password' => 'quizmo_dev',
			'charset' => 'utf8',
		),
<<<<<<< HEAD

=======
		*/
				
>>>>>>> 3f5ad3577ebe3f5c3c93c7f93eb9dc74c692ac1d
	),
);


?>