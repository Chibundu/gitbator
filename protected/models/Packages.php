<?php

/**
 * This is the model class for table "{{packages}}".
 *
 * The followings are the available columns in table '{{packages}}':
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $picture
 * @property string $cost
 * @property string $cost_type
 * @property integer $delivery
 * @property string $instructions
 * @property integer $units_bought
 * @property integer $vote_up
 * @property integer $vote_down
 * @property integer $discount
 * @property integer $serviceproviders_id
 * @property integer $servicecategories_id
 * @property integer $currencies_id
 * @property integer $last_modified
 * @property integer $created_on
 *
 * The followings are the available model relations:
 * @property PackageDeliverables[] $packageDeliverables
 * @property PackageExcluded[] $packageExcluded
 * @property Serviceprovider $serviceproviders
 * @property Servicecategories $servicecategories
 * @property Currencies $currency
 */
class Packages extends CActiveRecord
{
	const PER_MONTH = 1;
	const PER_ANNUM = 2;
	const PER_HOUR = 3;
	const ONE_OFF = 4;
	
	public $deliverables;
	public $excluded;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Packages the static model class
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
		return '{{packages}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('serviceproviders_id, servicecategories_id, title, description, deliverables, cost', 'required'),
			array('deliverables', 'checkDeliverables', 'message'=> 'The Service Deliverables must be clearly outlined'),
			array('deliverables, excluded', 'safe'),					
			array('delivery, serviceproviders_id, servicecategories_id, units_bought, vote_up, vote_down', 'numerical', 'integerOnly'=>true),
			array('discount', 'numerical'),
			array('picture', 'file', 'types'=>'jpg, gif, png', 'allowEmpty'=>'true', 'maxSize'=>5242880),
			array('picture', 'default', 'value'=>'default/service_package.png'),
			array('description, cost, cost_type', 'length', 'max'=>500),
			array('title', 'length', 'max'=>78),
			array('instructions', 'length', 'max'=>500),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, title, description, picture, cost, cost_type, delivery, instructions, serviceproviders_id, servicecategories_id', 'safe', 'on'=>'search'),
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
			'packageExcluded' => array(self::HAS_MANY, 'PackageExcluded', 'packages_id'),
			'packageDeliverables' => array(self::HAS_MANY, 'PackageDeliverables', 'packages_id'),
			'serviceprovider' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),
			'servicecategories' => array(self::BELONGS_TO, 'Servicecategories', 'servicecategories_id'),
			'currency'=>array(self::BELONGS_TO, 'Currencies', 'currencies_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'title' => 'Title for Service Package',
			'description' => 'Description of Service Package',
			'picture' => 'Add Picture',
			'cost' => 'Cost',
			'cost_type' => 'Cost Type',
			'delivery' => 'Estimated Delivery Time (in days)',
			'instructions' => 'Instructions to buyer',
			'units_bought'=>'Units Bought',
			'serviceproviders_id' => 'Serviceproviders',
			'servicecategories_id' => 'Servicecategories',
			'currency_id' => 'Currency',
			'deliverables'=>'The Deliverables',
			'excluded'=>'What is not included in this service',
			'vote_up'=>'Vote Up',
			'vote_down'=>'Vote Down',
			'discount'=>'Discount',
			'last_modified'=>'Last Modified',
			'created_on'=>'Created On',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('picture',$this->picture,true);
		$criteria->compare('cost',$this->cost,true);
		$criteria->compare('cost_type',$this->cost_type,true);
		$criteria->compare('delivery',$this->delivery);
		$criteria->compare('instructions',$this->instructions,true);
		$criteria->compare('units_bought',$this->units_bought);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);
		$criteria->compare('servicecategories_id',$this->servicecategories_id);
		$criteria->compare('currencies_id',$this->currencies_id);
		$criteria->compare('vote_up',$this->vote_up);
		$criteria->compare('vote_down',$this->vote_down);
		$criteria->compare('discount',$this->discount);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * The cost types for the package
	 * @return array key value pairs of cost types
	 */
	public static function costTypes()
	{	
		return array(self::ONE_OFF => 'One off', self::PER_HOUR=>'Per Hour', self::PER_MONTH=>'Per Month', self::PER_ANNUM=>'Per Annum');
	}
	
	/**	 
	 * Returns the cost type
	 * @param int $index
	 */
	public static function costType($index)
	{
		if($index == self::ONE_OFF)
		{
			return 'Only';
		}
		if($index == self::PER_HOUR)
		{
			return 'Per Hour';
		}
		if($index == self::PER_MONTH)
		{
			return 'Per Month';
		}
		if($index == self::PER_ANNUM)
		{
			return 'Per Annum';
		}
	}
	
	/**
	 * The estimated time of delivery in days
	 * @return array key value pair of 1 through 30
	 */
	public static function estimatedTimeOfDelivery()
	{
		return array(1=>1,2=>2,3=>3,4=>4,5=>5,6=>6,7=>7,8=>8,9=>9,10=>10,11=>11,12=>12,13=>13,14=>14,15=>15,16=>16,17=>17,18=>18,19=>19,20=>20,21=>21,22=>22,23=>23,24=>24,25=>25,26=>26,27=>27,28=>28,29=>29,30=>30);
	}
	
	
	public function afterSave()
	{
		$db = $this->getDbConnection();
		$command = $db->createCommand();
		
		if(!$this->isNewRecord){
			$command->delete('{{package_deliverables}}', 'packages_id='.$this->id );
			$command->delete('{{package_excluded}}', 'packages_id='.$this->id );
		}
		
		$deliverables = explode("\r\n", trim($this->deliverables));
		$id = $this->id;
		foreach($deliverables as $deliverable)
		{
			if(preg_match('/^([A-Za-z0-9\-_,&().  ])+$/', $deliverable))
				$command->insert('{{package_deliverables}}', array('packages_id'=>$id, 'deliverable'=>$deliverable));
		}
		if(strcasecmp(trim($this->excluded), "Item #1\r\nItem #2\r\nItem #3") != 0)
		{
			$excluded_items = explode("\r\n", trim($this->excluded));
			foreach($excluded_items as $item)
			{
				if(preg_match('/^([A-Za-z0-9\-_,&().  ])+$/', $item))
					$command->insert('{{package_excluded}}', array('packages_id'=>$id, 'item'=>$item));
			}
		}		
	}
	
	public function checkDeliverables($attributes, $params)
	{		
		if((strcasecmp($this->deliverables, "")==0) || (strcasecmp($this->deliverables, "Deliverable #1\r\nDeliverable #2\r\nDeliverable #3") == 0))
		{						
			$this->addError('deliverables', (($params['message'])?$params['message']:"The Service Deliverables must be clearly outlined"));
		}			
	}
	
	public function delete()
	{
		if(Yii::app()->user->checkAccess('sp-accountOwner', array('sp_id'=>$this->serviceproviders_id)))
		{
			$db = $this->dbConnection;
			$command = $db->createCommand();
			$command->delete('{{package_deliverables}}', 'packages_id='.$this->id);
			$command->delete('{{package_excluded}}', 'packages_id='.$this->id);
			if($this->picture != 'default/service_package.png')
			{
				@unlink(Yii::app()->params['service_packages_dir'].$this->picture);
				@unlink(Yii::app()->params['service_packages_dir']."larger/".$this->picture);
			}			
			parent::delete();
		}
		else
		{
			throw new CHttpException('400', 'You are not authorized to carry out this action. Please do not repeat this request again.');
		}		
	}
	
	public function behaviors()
	{
			return array(
 		 		'CTimestampBehavior' => array(
  				'class' => 'zii.behaviors.CTimestampBehavior',
  				'createAttribute' => 'created_on',
  				'updateAttribute' => 'last_modified',
  			)
  	);
	}
}