<?php

class QualForm extends CFormModel
{
	public $qual1;
	public $qual2;
	public $qual3;	
	public $qual4;
	public $from1;
	public $from2;
	public $from3;
	public $from4;
	public $to1;
	public $to2;
	public $to3;
	public $to4;
	public $type1;
	public $type2;
	public $type3;
	public $type4;
	public $ref1;
	public $ref2;
	public $ref3;
	public $ref4;
	public $desc1;
	public $desc2;
	public $desc3;
	public $desc4;
	public $inst1;
	public $inst2;
	public $inst3;
	public $inst4;

	/**
	 * Declares the validation rules.
	 * The rules state that username and password are required,
	 * and password needs to be authenticated.
	 */
	public function rules()
	{
		
		return array(	
			array('inst1, inst2, inst3, inst4, qual1, qual2, qual3, qual4, from4, to1, to2, to3, to4 ,type1, type2, type3, type4, ref1,ref2, ref3, ref4, desc1, desc2, desc3, desc4', 'safe'),		
		);
	}

	/**
	 * Declares attribute labels.
	 */
	public function attributeLabels()
	{
		return array(
			'qual1'=>'Qualification',
			'qual2'=>'Qualification',
			'qual3'=>'Degree',
			'ref1'=>'reference Number',
			'ref2'=>'reference Number',
			'ref3'=>'reference Number',
			'ref4'=>'Organizations',
			'desc1'=>'Description(Optional)',
			'desc2'=>'Description(Optional)',
			'desc3'=>'Description(Optional)',
			'desc4'=>'Description(Optional)',
			'qual4'=>'Profession',			
			'to1'=>'Year Awarded',					
			'to2'=>'Year Awarded',
			'to3'=>'Year Awarded',
			'from4'=>'From',
			'to4'=>'To',
			'type2'=>'Type',
			'type1'=>'Type',	
			'type3'=>'Type',
			'type4'=>'Type',
			'inst1'=>'Awarding Institution',
			'inst2'=>'Awarding Institution',
			'inst3'=>'Awarding Institution',
			'inst4'=>'Awarding Institution',
		);
	}
		
}
