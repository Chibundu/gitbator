<?php
/**
 * 
 * @author Chibundu Mbagwu
 * Contains configuration about custom Exceptions thrown on the vcubator
 *
 */
class GenericException extends CComponent{
	
	const UNEXPECTED_PARAMETER = 0;
	const MISSING_KEY = 0;

	public static function getMessage($code)
	{
		switch ($code) {
			case self::UNEXPECTED_PARAMETER:
				return "You have entered an unexpected parameter.";
			break;
			case self::MISSING_KEY:
				return "Can't find an important key. Check your parameters against the documentation.";
				break;
			default:
				return "An error has occured.";
			break;
		}		
	}
}

?>