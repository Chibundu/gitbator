<?php

// uncomment the following to define a path alias
Yii::setPathOfAlias('bootstrap',dirname(__FILE__).'/../extensions/bootstrap');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'The Vcubator',	
	'language'=>'en',

	// preloading 'log' component
	'preload'=>array('log', 'ext.bootstrap'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',		
		'application.components.payment.*',
		'application.components.payment.behaviors.*',
		'bootstrap.widgets.*',
		'ext.helpers.XHtml',
		'application.utilities.*',
		'application.behaviors.*',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123',
		 	// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
			'generatorPaths'=>array(
				'bootstrap.gii',
			),
		),
		'serviceproviders',
		'admin',
		
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		// uncomment the following to enable URLs in path-format
		
		'urlManager'=>array(
			'class' => 'ext.components.language.XUrlManager',
			'urlFormat'=>'path',
			'showScriptName'=>false,
			'appendParams'=>false,
			'rules'=>array(
				'<language:\w{2}>' => 'site/index',
				'<language:\w{2}>/<_c:\w+>' => '<_c>',
				'<language:\w{2}>/<_c:\w+>/<_a:\w+>'=>'<_c>/<_a>',
				'<language:\w{2}>/<_m:\w+>' => '<_m>',
				'<language:\w{2}>/<_m:\w+>/<_c:\w+>' => '<_m>/<_c>',
				'<language:\w{2}>/<_m:\w+>/<_c:\w+>/<_a:\w+>' => '<_m>/<_c>/<_a>',
			),
		),		
		
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=mobinatr_vcubator',
			'emulatePrepare' => true,
			'username' => 'mobinatr',
			'password' => 'Red123hot#',
			'charset' => 'utf8',
			'tablePrefix'=>'tbl_',
			'schemaCachingDuration' => 180,
		
			'enableProfiling'=>true,
			'enableParamLogging' => true,
		),
		'authManager'=> array(
			'class'=>'CDbAuthManager',							
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
      //  'paymentTransaction'=>require dirname(__FILE__).'/payment_config.php',
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
				// uncomment the following to show log messages on web pages		
				/*array(
					'class'=>'CWebLogRoute',
				),	*/
				array(
					'class'=>'CFileLogRoute',
					'levels'=>CLogger::LEVEL_TRACE,
					'categories'=>'registration',
					'logFile'=>'registration',
				),				
			),
		),
		'bootstrap'=>array(
			'class'=>'ext.bootstrap.components.Bootstrap',
		),
		'clientScript'=>array(
			'scriptMap'=>array(
				'bootstrap.min.css'=>"/css/bootstrap.min.css",
				'bootstrap-responsive.min.css'=>"/css/bootstrap-responsive.min.css",
				'bootstrap-transition.js'=>'/js/bootstrap.min.js',
				'bootstrap-button.js'=>'/js/bootstrap.min.js',
				'bootstrap-tooltip.js'=>'/js/bootstrap.min.js',
				'bootstrap-popover.js'=>'/js/bootstrap.min.js',
				'bootstrap-alert.js'=>'/js/bootstrap.min.js',
				'bootstrap-carousel.js'=>'/js/bootstrap.min.js',
				'bootstrap-dropdown.js'=>'/js/bootstrap.min.js',
				'bootstrap-modal.js'=>'/js/bootstrap.min.js',
				'bootstrap-scrollspy.js'=>'/js/bootstrap.min.js',
				'bootstrap-tab.js'=>'/js/bootstrap.min.js',
				'bootstrap-typeahead.js'=>'/js/bootstrap.min.js',														 				
			),
		),	
		'request'=>array(
			'enableCsrfValidation'=>true,
			'enableCookieValidation'=>true,
		),
		'image'=>array(			
			'class'=>'application.extensions.image.CImageComponent',
			'driver'=>'GD',
			'params'=>array('directory'=>'opt/local/bin'),
		),
		'session'=>array(
 			'class'=>'CHttpSession', 
		),
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require dirname(__FILE__).'/params.php'
		
		
	
);
