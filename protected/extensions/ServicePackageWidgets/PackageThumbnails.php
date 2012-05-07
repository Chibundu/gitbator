<?php
class PackageThumbnails extends CWidget
{
	public $packages;
	
	public $isMini = false;
	
	public function run()
	{
		if(!$this->isMini){
			$this->render("thumbnails", array('packages'=>$this->packages));
		}
		else
		{
			$this->render("mini_thumbnails", array('packages'=>$this->packages));
		}
	}
}
?>
