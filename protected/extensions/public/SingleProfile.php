<?php
class SingleProfile extends CWidget
{
	/**	 
	 * Service Provider Instance
	 * @var Serviceproviders
	 */
	public $sp;
	
	public function init()
	{		
		$this->render('SingleProfile',array('sp'=>$this->sp));		
	}
}
?>