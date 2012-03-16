<?php
	class AvailabilityForm extends CFormModel
	{
		public $isAvailable = false;		
		public $isWorkOnWeekends = false;
		
		public function rules()
		{
			return array(
				array('isAvailable, isWorkOnWeekends','numerical', 'integerOnly'=>true),
			);	
		}
		
		public function attributeLabels()
		{
			return array(
				'isAvailable'=>'',
				'isWorkOnWeekends'=>'',
			);
		}
		
		
	}
?>