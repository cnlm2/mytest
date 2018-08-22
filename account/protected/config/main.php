<?php

define('UC_CONNECT', 'mysql');
define('UC_DBHOST', 'localhost');
define('UC_DBUSER', 'root');
define('UC_DBPW', '');
define('UC_DBNAME', 'gsbbs');
define('UC_DBCHARSET', 'utf8');
define('UC_DBTABLEPRE', '`gsbbs`.pre_ucenter_');
define('BBS_DBTABLEPRE', '`gsbbs`.pre_common_');
define('UC_DBCONNECT', '0');
define('UC_KEY', 'O6x8mda1y1F4A49di18dd0efw4c6P0M2ha1df7r3l555J9Q5v1jaVe7dU84bPbm7');
define('UC_API', 'http://gshx.greenyouxi.com/bbs/uc_server');
define('UC_CHARSET', 'utf-8');
define('UC_IP', '');
define('UC_APPID', '1');
define('UC_PPP', '20');

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'拍拍投用户中心',

	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'jingyong',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:[-0-9a-fA-F]+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:[-0-9a-zA-Z_]+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		 */
		'db'=>array(
			'connectionString' => 'mysql:host=127.0.0.1;dbname=account',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
			'schemaCachingDuration'=>3600,
		),
		
		'cache'=>array(
			'class' => 'CFileCache',
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
					'levels'=>'error, warning',
				),
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'info',
					'categories'=>'recharge.*',
					'logFile'=>'recharge.log',
				),
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		'curl' =>array(
			'class' => 'application.extensions.curl.Curl',
		),
		'idcard' =>array(
			'class' => 'application.extensions.validators.idCard',
		),

	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'webmaster@example.com',
	),
);
