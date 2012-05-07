<?php

class PackageOrder extends CWidget {
	
	public $package_title;
	
	public $package_pic;
	
	public $status;
	
	public $instructions;
	
	public $spId;
	
	public $spName;
	
	public $dateOrdered;
	
	public $order_id;
	
	public $order_req;
	
	public $etPic;
	
	public $etName;
	
	public $tlName;
	
	public $tlPic;	
	
	public $isReqSent;
	
	public $hasMessage;
	
	public $duration;
	
	public function run()
	{
		$this->render('package_order',
			 array(
			 		'package_title'=>$this->package_title,
			 		'package_pic'=>$this->package_pic, 
			 		'status'=>$this->status,
			 		'instructions'=>$this->instructions, 
			 		'spId'=>$this->spId,
			 		'spName'=>$this->spName,
			 		'dateOrdered'=>$this->dateOrdered,	
			 		'order_id'=>$this->order_id,	
			 		'order_req'=>$this->order_req,
			 		'etPic'=>$this->etPic,
			 		'etName'=>$this->etName,
			 		'tlName'=>$this->tlName,
			 		'tlPic'=>$this->tlPic,			 		
			 		'isReqSent'=>$this->isReqSent,
			 		'hasMessage'=>$this->hasMessage,
			 		'duration'=>$this->duration,
			  )
		);
	}

}

?>