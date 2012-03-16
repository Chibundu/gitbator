<?php

class CurrencyConverter {
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