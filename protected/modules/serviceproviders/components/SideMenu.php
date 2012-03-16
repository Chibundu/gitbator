<?php

Yii::import('zii.widgets.CPortlet');

/** 
 * @author Mbagwu Chibundu
 * 
 * 
 */
class SideMenu extends CWidget {
	
	public $links = array();
	public function init()
	{		
		parent::init();
		$this->renderContent();
	}
	public function renderContent()
	{
		$this->render('sideMenu', array('links'=>$this->links));
	}

}

?>