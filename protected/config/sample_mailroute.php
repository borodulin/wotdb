<?php
return array(
	'utf8'=>true,
	'subject'=>'Console error',
	'class'=>'CEmailLogRoute',
	'levels'=>'error',
	'emails'=>'admin@domain',
	'except'=>'exception.CHttpException.*',
);