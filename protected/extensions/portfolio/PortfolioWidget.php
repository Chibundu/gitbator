<?php
class PortfolioWidget extends CWidget {
	public $portfolio;
	public function init()
	{		
		$this->render('portfolio',array('portfolio'=>$this->portfolio));		
	}
	
	
}

?>