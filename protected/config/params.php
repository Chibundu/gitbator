<?php
return array(
'title'=>'The Vcubator',
'adminEmail'=>'webmaster@example.com',
	'pageSize'=>5,
	// this is displayed in the header section
	'title'=>'Vcubator',
	// this is used in error pages
	'adminEmail'=>'webmaster@vcubator.co.za',	
	// the copyright information displayed in the footer section
	'copyrightInfo'=>'Copyright &copy; '.date('Y').' Bright Group.',
	//dropdown picks
	'gender'=>array('Male'=>'Male', 'Female'=>'Female'),
	'provinces'=>array(							
						'Gauteng'=>'Gauteng', 	
						'Eastern Cape'=>'Eastern Cape',
						'Freestate'=>'Freestate',											
						'Limpopo'=>'Limpopo',
						'Mpumalaga'=>'Mpumalaga',
						'Northern Cape'=>'Northern Cape',
						'Western Cape'=>'Western Cape',
						'International'=>'Other', 
						),
	'industries'=>array(
						'Other'=>'Other',
						'Agriculture'=>'Agriculture',
						'Education'=>'Education',						
						'Information Technology'=>'Information Technology',
						'Health'=>'Health',
						'Retailing'=>'Retailing',
						'Manufacturing'=>'Manufacturing',
						'Mining'=>'Mining',						
						),
	//'countries'=>require (dirname(__FILE__).'/countries.php'),
	'timezones'=>require (dirname(__FILE__).'/timezones.php'),
	'hle'=>array(						
						'Matric'=>'Matric',
						'Bachelors Degree'=>'Bachelors Degree',
						'Masters Degree' => 'Masters Degree',
						'PhD'=>'PhD',
						'Self Taught'=>'Self Taught',
						'Other'=>'Other',
				),
	'typeOfReg'=>array(
						'None'=>'None',
						'CC'=>'CC',
						'Pty'=>'Pty',
				),
	'annualRevenue'=>array(
						'10 000 - 50 000' => '10 000 - 49 999',
						'50 000 - 99 999' => '50 000 - 99 999',
						'100 000 - 499 999' => '100 000 - 499 999',
						'500 000 - 999 999' => '500 000 - 999 999',
						'1 000 000 - 4 999 999'=>'1 000 000 - 4 999 999',
						'5 000 000 - 9 999 999'=>'5 000 000 - 9 999 999',
						'above 10 million' => 'above 10 million'
				),
	'companySize'=>array(
						'1 - 10' => '1 - 10 Staff',
						'10 - 20' => '10 - 20 Staff',
						'20 - 50' => '20 - 50 Staff',
						'50 - 100' => '50 - 100 Staff',
						'above 100'=>'above 100 staf',
				),
	'maxPortfolioSize' => 10, //10MB
	
	'PageSize' => 5,				
	
	'maxServices'=>5,	
	'infobip_username'=>'smswor1d',
	'infobip_password'=>'A56Grfc',
	'infobip_sender'=>'Vcubator',
	'clickatell_username'=>'mobinatric',
	'clickatell_password'=>'hl9AEybn',
	'clickatell_api_id'=>'3166777',
				
	'payment_gateways'=>array(
						'payfast'=>array(
							'merchant_id'=>array('label'=>'merchant_id', 'value'=>''),
							'merchant_key'=>array('label'=>'merchant_key', 'value'=>''),
							'notify_url'=>array('label'=>'notify_url', 'value'=>''),
							'return_url'=>array('label'=>'return_url', 'value'=>''),
							'cancel_url'=>array('label'=>'cancel_url', 'value'=>''),							
						),
						'paypal'=>array(
						),
				),
	'identity_verification'=>array(
					'amount'=>5.0,
					'currency'=>1,
				),
	'enc_key'=>'IfX2mmDV3cJp8G8',	
				
				
	'service_packages_dir'=>'service_packages/',			
				
);

?>