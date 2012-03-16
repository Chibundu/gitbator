<?php
/** 
 *Manages Links
 */
class Links
{
	public $controller;
	public function __construct($controller)
	{
		$this->controller = $controller;
	}
	
	/**	 
	 * A controller map helps the MappedMenu component determine which links should be marked as active by checking
	 * all controllers associated with it. For example the Profile link in the Service providers module is associated with 
	 * contact, team, portfolios, qualification, etc., controllers and therefore, when the current request emanates from any
	 * of these controllers the Profile link will be highlighted as active.
	 * @var array
	 */
	public static $sp_main_links = array(
				'Dashboard'=>array('default'),
				'Profile'=>array('profile', 'contact', 'team', 'portfolios', 'qualification','services','verifications','email','public'),
				'Jobs'=>array('jobs'),
				'Packages'=>array('packages'),
				'Settings'=>array('settings'),
			);
	/**	 
	 * See @link Links::sp_main_links for explanations. This is the menu map for admin module
	 * @var array
	 */		
	public static $ac_main_links = array();
			
	
	
		
	

	/**	 
	 * Used by the SideMenu Component to populate a vertical sidebar/similar menu with links associated with a particular controller
	 * @return an array of links(functions) associated with a given controller
	 */
	public function getLinks()
	{
		switch ($this->controller) {
			case 'profile':	
			case 'contact':	
			case 'team':
			case 'qualification':
			case 'portfolios':	
			case 'services':	
			case 'verifications': 
			case 'email':
			case 'public':	
				$sp = Miscellaneous::getServiceProvider();
				return array(
						array( 'text'=>'Overview','url'=>array('profile/')),
						array( 'text'=>'Contact Info','url'=>array('contact/')),
						array( 'text'=>'Team','url'=>array('team/')),
						array( 'text'=>'Portfolio','url'=>array('portfolios/')),
						array( 'text'=>'Qualifications','url'=>array('qualification/')),
						array( 'text'=>'Services','url'=>array('services/')),
						array( 'text'=>'Verifications','url'=>array('verifications/')),
						array( 'text'=>'Email','url'=>array('email/')),
						array( 'text'=>'Public Profile','url'=>array('public/index',  'displayName'=>$sp->displayName)),
					);
			break;
			
			
			case 'settings':
				return array(
							array( 'text'=>'Overview','url'=>array('settings/overview')),
							array( 'text'=>'Currency','url'=>array('settings/currency')),
							array( 'text'=>'TimeZone','url'=>array('settings/timezone')),
							array( 'text'=>'Availability','url'=>array('settings/availability')),						
						//	array( 'text'=>'Payment','url'=>array('settings/payment'))
						);
			break;
			
			case 'accessControl':
				return array(
					array( 'text'=>'General','url'=>array('accessControl/index')),
					array( 'text'=>'Create Auth Item','url'=>array('accessControl/create')),
					array( 'text'=>'Assign Privileges','url'=>array('accessControl/assign')),					
				);
			
			default:
				array();
			break;
		}
	}
	
	public static function getProfileControllers()
	{
		return array('profile', 'contact', 'team', 'qualification', 'portfolios', 'services', 'verifications', 'email', 'public');
	}
}
?>