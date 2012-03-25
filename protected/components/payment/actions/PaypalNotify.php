<?php
class PaypalNotify extends CAction {
	
	public function run() {		
		$string = '';
		var_dump($_POST);
		foreach ($_POST as $key=>$value)
		{
			$string.="$key=$value\r\n";
		}
		mail("mbagwu.c@gmail.com","important", $string);
		
	}
}

?>