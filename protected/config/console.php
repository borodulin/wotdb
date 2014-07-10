<?php

// This is the configuration for yiic console application.
// Any writable CConsoleApplication properties can be configured here.

$config=require(dirname(__FILE__).'/common.php');

$routes=array(
	array(
		'logFile'=>'console.log',
		'class'=>'CFileLogRoute',
		'levels'=>'error, warning',
	),
);

if(file_exists(__DIR__.'/mailroute.php'))
	$routes[]=require(__DIR__.'/mailroute.php');

$config=CMap::mergeArray($config,array(
	'name'=>'My Console Application',
	'components'=>array(
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>$routes,
		),
	),
));

return $config;