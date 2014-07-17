<?php

return array(
		'name'=>'Web Application Name',
		// application components
		'components'=>array(
				'db'=>array(
						'connectionString' => 'mysql:host=localhost;port=3306;dbname=wotdb',
						'emulatePrepare' => true,
						'username' => 'USERNAME',
						'password' => 'PASSWORD',
						'charset' => 'utf8',
						'tablePrefix' => 'tbl_',
				),
		),
		'params'=>array(
				'clan'=>11111,
				'tsUri'=>"serverquery://USERNAME:PASSWORD@127.0.0.1:10011/?server_port=9987",
				'application_id'=>'GO AND GET IT!!! https://ru.wargaming.net/developers/',
				'tsGroupFriend'=>'Друг',
				'tsGroupMember'=>'Солдат',
		),
);
