<?php
/**
 * Utility class to convert from one currency to another at the current exchange rate,
 * using google API
 * @author Mbagwu Chibundu
 *
 */
class CurrencyConverter {
	
	/**
	 * Converts currency values using the current exchage rate
	 * @param string $from the currency to convert from e.g ZAR
	 * @param double $amount the amount to be converted
	 * @param string $to the currency to convert to
	 */
	public static function convert($from, $amount, $to)
	{
		//make string to be put in API
		$string = '1'.$from."=?".$to;
 
		//Call Google API
		$google_url = "http://www.google.com/ig/calculator?hl=en&q=".$string;
		$result = file_get_contents($google_url);
		$result = explode('"', $result);
 
		################################
		# Right Hand Side
		################################
		$converted_amount = explode(' ', $result[3]);
		$conversion = $converted_amount[0];		
		//$conversion = preg_replace('/[x00-x08x0B-x1F]/', '', $conversion);
		if($conversion)
		{			
			return $conversion * $amount;
		}
		return false;
	}
}

?>