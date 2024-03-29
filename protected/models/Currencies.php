<?php

/**
 * This is the model class for table "{{currencies}}".
 *
 * The followings are the available columns in table '{{currencies}}':
 * @property integer $id
 * @property string $code
 * @property string $literal
 * @property string $symbol
 *	
 * The followings are the available model relations:
 * @property Jobs[] $jobs
 * @property Paymentmodel[] $paymentmodels
 * @property Serviceproviders[] $serviceproviders
 * @property Sppayments[] $sppayments
 */
class Currencies extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return Currencies the static model class
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
		return '{{currencies}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code', 'required'),
			array('code', 'length', 'max'=>4),
			array('literal', 'length', 'max'=>45),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, code, literal', 'safe', 'on'=>'search'),
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
			'jobs' => array(self::HAS_MANY, 'Jobs', 'currencies_id'),
			'paymentmodels' => array(self::HAS_MANY, 'Paymentmodel', 'currencies_id'),
			'serviceproviders' => array(self::HAS_MANY, 'Serviceproviders', 'currency_id'),
			'sppayments' => array(self::HAS_MANY, 'SpPayments', 'currencies_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'literal' => 'Literal',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('literal',$this->literal,true);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
}