<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.

date_default_timezone_set('Europe/Moscow');

return CMap::mergeArray(array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Yii Blog Demo',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	// application components
	'components'=>array(
		 'db'=>array(
	 		'connectionString' => 'mysql:host=localhost;dbname=DBNAME',
	 		'emulatePrepare' => true,
	 		'username' => 'USERNAME',
	 		'password' => 'PASSWORD',
	 		'charset' => 'utf8',
	 		'tablePrefix' => 'tbl_',
		 ),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),
),require(dirname(__FILE__).'/db.php'));
