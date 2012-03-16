<?php
$app = Yii::app();
$baseUrl = $app->request->baseUrl;
?>

<?php $app->clientScript->registerCssFile($app->request->baseUrl.'/css/bootstrap.min.css');?>
<?php $app->clientScript->registerCssFile($app->request->baseUrl.'/css/bootstrap-responsive.min.css');?>
<?php $app->clientScript->registerCssFile($app->request->baseUrl.'/css/custom.css');?>
		
	

	<?php if($sample==1):?>
	<?php
		$deliverables = array(); 
		
		$packageDeliverables = new PackageDeliverables();
		$packageDeliverables->deliverable = "Balance Sheets";
		$deliverables[] = $packageDeliverables;
		
		$packageDeliverables = new PackageDeliverables();
		$packageDeliverables->deliverable = "Cash Flow Statement";
		$deliverables[] = $packageDeliverables;
		
		$packageDeliverables = new PackageDeliverables();
		$packageDeliverables->deliverable = "Profit and Loss Account";
		
		$deliverables[] = $packageDeliverables;
		
		
		$excluded_items = array();
		
		$packageExcluded = new PackageExcluded();
		$packageExcluded->item = "Daily Ledgers";
		$excluded_items[] = $packageExcluded;
		
		$packageExcluded = new PackageExcluded();
		$packageExcluded->item = "Cash Account";
		$excluded_items[] = $packageExcluded;
		
		
		
	?>
	<h2>Monthly Bookkeeping for just R25/Month.</h2>
	<?php 
	
	$this->widget('ext.ServicePackageWidgets.SnapShot', array(
		'currencySymbol'=>'R',	
		'cost'=>'25',
		'cost_type'=>Packages::PER_MONTH,
		'delivery'=>30,
		'description'=>'I will provide basic monthly financial reporting for your business at just R25.',
		'picture'=>'samples/bk_sample.png',
		'packageDeliverables' => $deliverables,
		'packageExcluded' => $excluded_items,
		'instructions'=>'Submit All necessary documents at least 3 days before expected delivery',
		'units_bought'=>50,		
		'isSample'=>true,
		'packageRating'=>99,
	));?>	
	
	
	<?php elseif($sample == 2):?>	
	
	
	<?php
		$deliverables = array(); 
		
		$packageDeliverables = new PackageDeliverables();
		$packageDeliverables->deliverable = "5 page websites with good design";
		$deliverables[] = $packageDeliverables;
		
		$packageDeliverables = new PackageDeliverables();
		$packageDeliverables->deliverable = "PHP forms to collect emails addresses and inquiry from  visitors";
		$deliverables[] = $packageDeliverables;
		
		$packageDeliverables = new PackageDeliverables();
		$packageDeliverables->deliverable = "200X200 banner";
		
		$deliverables[] = $packageDeliverables;
		
		
		$excluded_items = array();
		
		$packageExcluded = new PackageExcluded();
		$packageExcluded->item = "Logo Design";
		$excluded_items[] = $packageExcluded;
		
		$packageExcluded = new PackageExcluded();
		$packageExcluded->item = "Monthly Hosting ";
		$excluded_items[] = $packageExcluded;
		
		$packageExcluded = new PackageExcluded();
		$packageExcluded->item = "Monthly maintenance";
		$excluded_items[] = $packageExcluded;
		
		
		
	?>
	<h2>5-page Corporate Website.</h2>
	<?php 
	
	$this->widget('ext.ServicePackageWidgets.SnapShot', array(
		'currencySymbol'=>'R',	
		'cost'=>'25',
		'cost_type'=>Packages::PER_MONTH,
		'delivery'=>30,
		'description'=>'Looking for a Small Business Website?  I will build a 5-page HTML website with  Design - Coding and On-page SE Optimization Included. You will get a beautiful website that is easy to maintain, collect your visitors email addresses so that you can contact them later, and an automated newsletter system.',
		'picture'=>'samples/service_package.png',
		'packageDeliverables' => $deliverables,
		'packageExcluded' => $excluded_items,
		'instructions'=>'Submit All necessary documents at least 3 days before expected delivery',
		'units_bought'=>45,		
		'isSample'=>true,
		'packageRating'=>75,
	
	));?>	  
	
	
	<?php elseif($sample == 3):?>	  
	
	<?php
		$deliverables = array(); 
		
		$packageDeliverables = new PackageDeliverables();
		$packageDeliverables->deliverable = "Drafting of Up to 5 business Contracts";
		$deliverables[] = $packageDeliverables;
		
		$packageDeliverables = new PackageDeliverables();
		$packageDeliverables->deliverable = "2 Partnership Agreement";
		$deliverables[] = $packageDeliverables;		
		
		
		$excluded_items = array();
		
		$packageExcluded = new PackageExcluded();
		$packageExcluded->item = "Full Legal representation in criminal cases";
		$excluded_items[] = $packageExcluded;
		
		$packageExcluded = new PackageExcluded();
		$packageExcluded->item = "Old disputes (any cases that arose prior to opting for this service)";
		$excluded_items[] = $packageExcluded;
		
		$packageExcluded = new PackageExcluded();
		$packageExcluded->item = "Matrimonial Matters e.g divorce, Maintenance";
		$excluded_items[] = $packageExcluded;
		
		
	?>
	<h2>I'll sue and do your contracts for only R150/Month.</h2>
	<?php 
	
	$this->widget('ext.ServicePackageWidgets.SnapShot', array(
		'currencySymbol'=>'R',	
		'cost'=>'25',
		'cost_type'=>Packages::PER_MONTH,
		'delivery'=>30,
		'description'=>'We will offer a comprehensive legal service to help you grow your business by helping you draw up  Shareholders Agreement, Business Agreements and up to 5 business contracts every month.',
		'picture'=>'samples/legal_sample.png',
		'packageDeliverables' => $deliverables,
		'packageExcluded' => $excluded_items,
		'instructions'=>'All suits will require at least 24hour notice. We will require to submit legal documents at least 3 days ahead of time.',
		'units_bought'=>500,		
		'isSample'=>true,
		'packageRating'=>80,
	));?>	
	
	
	<?php endif;?>
		
		  

