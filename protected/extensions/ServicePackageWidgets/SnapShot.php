<?php

class SnapShot extends CWidget {
	
	/**	 
	 * Whether this is a sample or not
	 * @var boolean
	 */
	public $isSample = false;
	
	/**	 
	 * The model
	 * @var Packages
	 */
	public $model;
	
	/**	 
	 * The currency symbol
	 * @var string
	 */
	public $currencySymbol;
	
	/**	 
	 * The cost
	 * @var double
	 */
	public $cost;
	
	/**	 
	 * The cost type
	 * @var int
	 */
	public $cost_type;
	
	/**	 
	 * The number of days to delivery
	 * @var int
	 */
	public $delivery;
	
	/**	 
	 * The description of the service
	 * @var string
	 */
	public $description;
	
	/**	 
	 * The path to the descriptive picture for this service
	 * @var string
	 */
	public $picture;
	
	/**	 
	 * The deliverables
	 * @var array of PackageDeliverables Objects
	 */
	public $packageDeliverables;
	
	/**	 
	 * The excluded items
	 * @var array of PackageExcluded Objects
	 */
	public $packageExcluded;
	
	/**	 
	 * The instructions
	 * @var string
	 */		
	public $instructions;
	
	/**	 
	 * The number of units that have been bought to date
	 * @var int
	 */
	public $units_bought;
	
	/**	 
	 * The rating of the package
	 * @var integer
	 */
	public $packageRating;
	
	public function run()
	{
		$this->render('snapshot', array(
			'model'=>$this->model,
			'currencySymbol'=>$this->currencySymbol,
			'cost'=>$this->cost,
			'cost_type'=>$this->cost_type,
			'delivery'=>$this->delivery,
			'description'=>$this->description,
			'picture'=>$this->picture,
			'packageDeliverables'=>$this->packageDeliverables,
			'packageExcluded'=>$this->packageExcluded,
			'instructions'=>$this->instructions,
			'units_bought'=>$this->units_bought,
			'isSample'=>$this->isSample,
			'packageRating'=>$this->packageRating,
		));	
	}

}

?>