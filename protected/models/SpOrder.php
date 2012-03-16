<?php

class SpOrder extends Order {
/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{spOrder}}';
	}
	
	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'verificationsWithOrders'=>array(self::MANY_MANY, 'Verifications', 'tbl_verifications_has_tbl_spOrder(verifications_id, spOrder_id)'),
			'qualificationsWithOrders'=>array(self::MANY_MANY, 'Qualification', 'tbl_qualification_has_tbl_spOrder(qualification_id, spOrder_id)')
		);
	}
	
	public function rules()
	{
		return CArray::merge(
			parent::rules(),
			array(
				array('serviceproviders_id', 'required'),
				array('serviceproviders_id', 'numerical', 'integerOnly'),
			)
		);
	}
	
	public function attributeLabels()
	{
		return CArray::merge(
			parent::attributeLabels(),
			array(
				'serviceproviders_id'=>'Service Providers',				
			)
		);
	}
	
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('amount',$this->amount);
		$criteria->compare('status',$this->status);
		$criteria->compare('create_time',$this->create_time);
		$criteria->compare('lastModified',$this->lastModified);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);
		$criteria->compare('currencies_id',$this->currencies_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}

?>