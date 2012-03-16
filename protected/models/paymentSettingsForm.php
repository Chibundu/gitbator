<?php

class paymentSettingsForm extends CFormModel {
	
	public $type;
	public $value;
	public $discount;
	public $service_id;
	public $serviceprovider_id;
	public $range_start;
	public $range_stop;
	
	public function rules()
	{
		return array(
			array('serviceproviders_id, service_id, value, type, discount', 'required'),
		);
	}
	

}

?>