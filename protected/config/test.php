<?php
Yii::setPathOfAlias('bootstrap',dirname(__FILE__)."/../extensions/bootstrap");
return CMap::mergeArray(
	require(dirname(__FILE__).'/main.php'),
	array(		
		'components'=>array(		
			'fixture'=>array(
				'class'=>'system.test.CDbFixtureManager',
			),			
			'db'=>array(
				'connectionString'=>'mysql:host=localhost;dbname=mobinatr_vcubatortest',
			),
			
		),
	)
);

