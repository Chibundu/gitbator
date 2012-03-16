<?php

/**
 * This is the model class for table "{{availability}}".
 *
 * The followings are the available columns in table '{{availability}}':
 * @property integer $id
 * @property integer $day
 * @property integer $start
 * @property integer $end
 * @property integer $isAvailable
 * @property integer $serviceproviders_id
 *
 * The followings are the available model relations:
 * @property Serviceproviders $serviceproviders
 */
class Availability extends CActiveRecord
{
	 const SUNDAY = 1;
	 const MONDAY = 2;
	 const TUESDAY = 3;
	 const WEDNESSDAY = 4;
	 const THURSDAY = 5;
	 const FRIDAY = 6;
	 const SATURDAY = 7;
	/**
	 * Returns the static model of the specified AR class.
	 * @return Availability the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{availability}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('id, serviceproviders_id', 'required'),
			array('id, day, isAvailable, serviceproviders_id', 'numerical', 'integerOnly'=>true),
			array('start, end','length', 'min'=>5, 'max'=>5),
			array('start, end', 'match', 'pattern'=>'/^\d{2}:\d{2}$/'),
			array('start', 'validateStartEnd'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, day, start, end, serviceproviders_id', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'serviceproviders' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'day' => 'Day',
			'start' => 'Begin Time',
			'end' => 'Close Time',
			'serviceproviders_id' => 'Serviceproviders',
			'isAvailable'=>'',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('day',$this->day);
		$criteria->compare('start',$this->start);
		$criteria->compare('end',$this->end);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * @return the day of the week associated with a given Availability object in literal form .e.g 'Sunday','Monday', etc.
	 */
	public function getDayLiteral()
	{
		$day = $this->day;
		switch($day)
		{
			case self::SUNDAY:
				return 'Sunday';
				break;
			case self::MONDAY:
				return 'Monday';
			case self::TUESDAY:
				return 'Tuesday';
			case self::WEDNESSDAY:
				return 'Wednessday';
			case self::THURSDAY:
				return 'Thursday';
			case self::FRIDAY:
				return 'Friday';
			case self::SATURDAY;
				return 'Saturday';		
		} 	
	}
	
	/**
	 * Ensures that the start time is not greater than the end time
	 */
	public function validateStartEnd($attribute, $params)
	{
		$start = $this->start;
		$end = $this->end;
		
		$start_in_parts = explode(':',$start);
		  
		$mstart = 60 * $start_in_parts[0] + $start_in_parts[1];
		
		$end_in_parts =  explode(':', $end);
		$mend = 60 * $end_in_parts[0] + $end_in_parts[1];
		
		if($mend < $mstart)
		{
			$this->addError('start','Start Time should not be after End Time');						
		}		
	}
}