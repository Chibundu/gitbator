<?php

Yii::import('zii.widgets.CPortlet');

/** 
 * @author Mbagwu Chibundu
 * 
 * 
 */
class ProfileMenu extends CPortlet {

	public function init()
	{
		$this->title = 'Profile Menu';
		parent::init();
	}
	public function renderContent()
	{
		$this->render('profileMenu');
	}

}

?>