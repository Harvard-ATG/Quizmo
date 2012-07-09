<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return CMap::mergeArray(
	require(dirname(__FILE__).'/database.php'),
	require(dirname(__FILE__).'/facebook.php'),
	require(dirname(__FILE__).'/ldap.php'),
	require(dirname(__FILE__).'/isites.php'),
	array(
		'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
		'name'=>'Quizmo',
		'defaultController' => 'site',


		// preloading 'log' component
		'preload'=>array('log'),

		// autoloading model and component classes
		'import'=>array(
			'application.models.*',
			'application.components.*',
		),
		
		// need to change this for isites
		//'layout'=>"main",
		'layout'=>"isites",

		'modules'=>array(
			// uncomment the following to enable the Gii tool
			'gii'=>array(
				'class'=>'system.gii.GiiModule',
				'password'=>'giipassword',
			 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
				'ipFilters'=>array('*'),
			),
		),

		// application components
		'components'=>array(
			'user'=>array(
				// enable cookie-based authentication
				'allowAutoLogin'=>true,
			),

			// uncomment the following to enable URLs in path-format
			'urlManager'=>array(
				'urlFormat'=>'path',
				'rules'=>array(
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>/<id:\d+>/<id2:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
			),


			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),
			'errorHandler'=>array(
				// use 'site/error' action to display errors
	            'errorAction'=>'site/error',
	        ),
			'log'=>array(
				'class'=>'CLogRouter',
				'routes'=>array(
					array(
						'class'=>'CFileLogRoute',
						'levels'=>'trace, info, error, warning',
					),
					// uncomment the following to show log messages on web pages
					/*
					array(
						'class'=>'CWebLogRoute',
					),
					*/
				),
			),

			
			'viewRenderer'=>array(
		  		'class'=>'ext.smarty-renderer.ESmartyViewRenderer',
		    	'fileExtension' => '.tpl',
		    	//'pluginsDir' => 'ext.smarty-renderer.plugins',
		    	'pluginsDir' => 'application.smartyPlugins',
		    	//'configDir' => 'application.smartyConfig',
		    	//'prefilters' => array(array('MyClass','filterMethod')),
		    	//'postfilters' => array(),
		    	//'config'=>array(
		    	//    'force_compile' => YII_DEBUG,
		    	//   ... any Smarty object parameter
		    	//)
			),
			
			'session' => array (
	    		'autoStart' => true,
				'sessionName' => 'QUIZMO',
	    		//'cookieMode' => 'only',
	    		'savePath' => '/web/quizmo/var/tmp/',
			),
			
		),



		// application-level parameters that can be accessed
		// using Yii::app()->params['paramName']
		'params'=>array(
			// this is used in contact page
			'adminEmail'=>'jcleveng@fas.harvard.edu',
<<<<<<< HEAD
			//'authMethod'=>'facebook',
			'authMethod'=>'isites',
			'default_redirect'=>'http://quizmo.harvard.edu',
=======
			'authMethod'=>'facebook',
			//'authMethod'=>'isites',
>>>>>>> a07223e88f78271dca2257052fd2ddc0ee2bd3d1
		),

		// comment this if you don't want the login to be forced (if you want to allow viewer level guests)
		// NOTE: gii will not work with this on
		// NOTE: isites needs this...
		'behaviors' => array(
		    'onBeginRequest' => array(
		        'class' => 'application.components.RequireLogin',
		    )
		),
		
		

	)
);
