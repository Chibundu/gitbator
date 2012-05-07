<?php

Yii::import('serviceproviders.models.*');
Yii::import('entrepreneurs.controllers.*');

class PackagesTest extends CTestCase {

	public function testShuffle()
	{
		$entPackageController = new PackagesController('pc', 'entrepreneur');
		
		$elements = array('tolu', 'tayo', 'temi', 'tope', 'titi', 'tony');		
		
		$shuffled = $entPackageController->shuffle($elements);
		
		$this->assertNotEquals($elements, $shuffled, 'Cannot validate that an array is properly shuffled. entrepreneurs.PackagesController::shuffle()');
		
	}
		
}

?>