<?php

/**
 * This is the model class for table "{{portfolios}}".
 *
 * The followings are the available columns in table '{{portfolios}}':
 * @property integer $id
 * @property string $tag
 * @property string $resource_location
 * @property string $Description
 * @property double $size
 * @property integer $serviceproviders_id
 *
 * The followings are the available model relations:
 * @property Serviceproviders $serviceprovider
 */
class Portfolios extends CActiveRecord
{
	/**
	 * @var supported image types
	 */
	public $imageTypes = 'jpg,png,gif'; 
	/**
	 * Returns the static model of the specified AR class.
	 * @return Portfolios the static model class
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
		return '{{portfolios}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('tag,Description', 'required'),			
			array('associated_link', 'url'),
			array('resource_location','file','types'=>$this->imageTypes.',pdf,ppt,doc,docx,pptx','on'=>'create'),
			array('serviceproviders_id', 'numerical', 'integerOnly'=>true),
			array('tag', 'length', 'max'=>45),
			array('Description', 'length', 'max'=>512),			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, tag, resource_location, Description, serviceproviders_id', 'safe', 'on'=>'search'),
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
			'serviceprovider' => array(self::BELONGS_TO, 'Serviceproviders', 'serviceproviders_id'),			
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'tag' => 'Title',
			'resource_location' => 'Portfolio Resource',
			'associated_link' => 'Associated Link',
			'Description' => 'Description',
			'serviceproviders_id' => 'Serviceproviders',
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
		$criteria->compare('tag',$this->tag,true);
		$criteria->compare('resource_location',$this->resource_location,true);
		$criteria->compare('Description',$this->Description,true);
		$criteria->compare('serviceproviders_id',$this->serviceproviders_id);

		return new CActiveDataProvider(get_class($this), array(
			'criteria'=>$criteria,
		));
	}
	
	public function getResourceType()
	{
		$ext = '';
		if(strrpos($this->resource_location, '.')!==false){			
			$offset = strrpos($this->resource_location, '.') + 1;
			$ext = strtolower(substr($this->resource_location, $offset));
		}		
		return $ext;
	}
	/**
	 * @return boolean determines whether the resource is an image
	 */
	public function getResourceIsImage()
	{		
		$imageTypes = explode(',', $this->imageTypes);			
		return in_array($this->resourceType, $imageTypes);  
		
	}	
	
}