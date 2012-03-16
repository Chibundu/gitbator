<?php
/** 
 * This behavior provides methods that either attach prefixes to id fields 
 * or work with ids that are prefixed. 
 * @author Chibundu Mbagwu
 *
 */
class PrefixedIdsBehavior extends CActiveRecordBehavior {
	/**	 
	 * @return string a suitable prefix based on the Model
	 * when this behavior is attached to @link Serviceproviders model, it returns sp-
	 * when this behavior is attached to the @link Users model, it returns ent-
	 * when this behavior is attached to the @link Mentors model, it returns ment-
	 * the default prefix is ord-
	 */
	public function getPrefix()
	{
		$class = get_class($this->getOwner());
		switch ($class){
		case 'Serviceproviders': 
			return 'sp-';
		case 'Users':
			return 'ent-';
		case 'Mentors':
			return 'ment-';
		default: 
			return 'ord-';
			
		}
	}
	
	/**	 
	 *@return string a version of the id that is prefixed with the prefix returned from @see PrefixedIdsBehavior::getPrefix()
	 */
	public function getPrefixedId()
	{		
		return $this->prefix.$this->getOwner()->id;
	}
}

?>