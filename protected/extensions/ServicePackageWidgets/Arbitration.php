<?php

class Arbitration extends CWidget {
	
	public $order;
	
	public $spId;
	
	public $etId;
	
	public $type;
	
	public function run()
	{
		$assets_dir = dirname(__FILE__)."/assets";
		$app = Yii::app();
		$cs = $app->clientScript;
		$cs->registerScriptFile($app->assetManager->publish($assets_dir."/js/arbitrate.js"), CClientScript::POS_END);
		
		$this->render('arbitration');
	}

}

?>