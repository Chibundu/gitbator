<?php

class Box extends CWidget {
	/**	 
	 * The title of the package
	 * @var string
	 */
	public $package_title;
	/**	 
	 * The directory containing the package images
	 * @var string
	 */
	public $package_dir;
	/**	 
	 * The image/picture describing the package
	 * @var string
	 */
	public $package_picture;
	
	/**	 
	 * The link leading to more info on this package(the view page)
	 * @var unknown_type
	 */
	public $package_title_link;
	
	/**	 
	 * The currency symbol(html code) of this package
	 * @var string
	 */
	public $currency_symbol;
	
	/**	 
	 * The cost of this package
	 * @var double
	 */
	public $package_cost;
	
	/**	 
	 * The cost type code e.g one off, per hour, per month,etc
	 * @var int
	 */
	public $package_cost_type;
	
	/**	 
	 * The estimated delivery for this package
	 * @var int
	 */
	public $package_delivery;
	
	/**	 
	 * How many units of this package have been bought to date
	 * @var int
	 */
	public $units_bought;
	
	/**	 
	 * CSS Class to be applied to the box
	 * @var string
	 */
	public $class;
	
	/**	 
	 * The primary key of the Package
	 * @var int
	 */
	public $package_id;
	
	
	public function run()
	{
		$baseUrl = Yii::app()->request->baseUrl;
		
		echo '<div class = "offer_box prepend-top box_shadow '.(($this->class)?$this->class:'').'"><!-- The box -->
				<div style = "margin: 2px;"> <!-- The Package Image -->
							<div class = "row-fluid">'.
								CHtml::image($baseUrl.'/'.$this->package_dir.$this->package_picture, 'Service Package', array('class'=>'span12')).'
							</div>
				</div>	<!-- End The Package Image -->
				
				<div style = "margin: 5px 5px 10px 5px; font-size: 1.1em; "> <!-- The Package Title -->'.
				CHtml::link($this->package_title, $this->package_title_link, array('class'=>'box_title'))
				.'</div> <!-- End The Package Title -->
				
				<div style = "margin: 5px;"> <!-- The Package Info -->
							<div class = "row-fluid">
								<div class = "span4">'.
								 '<span class = "bold">'. $this->currency_symbol. $this->package_cost.'</span><br><span class = "bold help-block" style = "font-size: 0.8em;">'. Packages::costType($this->package_cost_type).'</span>'.'
								</div>
								<div class = "span4">'.'<span class = "bold">'.$this->package_delivery. '</span><span class = "bold"> day'.(($this->package_delivery > 1)? 's' : '').' </span> <br><span class = "bold help-block" style = "font-size: 0.8em;">Est. Delivery</span>				
								</div>
								<div class = "span4 bold">
									'.$this->units_bought.' <i class = "icon-shopping-cart"></i>
								</div>
							</div>							
				</div>	<!-- End The Package Info -->	
			</div> <!-- End of The Box -->';
		if($this->package_id){	
		echo '<div class = "offer_box_control box_shadow">
				<div class = "row-fluid">
					<div class = "span4">'.CHtml::link('<i class = "icon-pencil"></i> Edit', array('packages/update', 'id'=>$this->package_id),array('class'=>'update_link')).'</div>
					<div class = "span4">'.CHtml::beginForm(array('packages/delete', 'id'=>$this->package_id)).CHtml::link('<i class = "icon-trash"></i> Delete','#',array('class'=>'delete_link')).CHtml::endForm().'</div>
					<div class = "span4">'.CHtml::link('<i class = "icon-eye-open"></i> View', $this->package_title_link, array('class'=>'view_link')).'</div>
				</div>
			 </div>
				
		';				
		}		
		
	}

}

?>