<?php

$isSandbox = false;
$sandboxHost = 'ssl://www.sandbox.paypal.com';

$fh = fopen("paypal_notify_debug.txt", "a");

$liveHost = 'ssl://www.paypal.com';
if(isset($_GET['sandbox']) && $_GET['sandbox'] == '1'){
	$isSandbox = true;
}




	fwrite($fh, "picked up payment with id $payment_id\r\n"); //DEBUG
	
	$req = "cmd=_notify-validate";
	
	$isMagicQuotesOn = false;
	if(function_exists('get_magic_quotes_gpc'))
	{
		if(get_magic_quotes_gpc() == true)
		{
			$isMagicQuotesOn = true;			
		}
	}	
	
	if($isMagicQuotesOn)
	{
		foreach ($_POST as $key=>$value)
		{
			if($key == 'test_ipn' && $value == '1')
			{
				$isSandbox = true;
			}
			
			$req.="&$key=".urlencode(stripslashes($value));
		}	
	}
	else
	{
		foreach ($_POST as $key=>$value)
		{
			if($key == 'test_ipn' && $value == '1')
			{
				$isSandbox = true;
			}
				
			$req.="&$key=".urlencode($value);
		}
	}	
	
	
	
	
	fwrite($fh, "post variables: $req \r\n"); //DEBUG
	
	$header  = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: x-www-form-urlencoded\r\n";
	$header .= "Content-Length:".strlen($req)."\r\n\r\n";	
	
	$fp = fsockopen(($isSandbox)? $sandboxHost : $liveHost, 443, $errno, $errstr, 30);
	
	if(!$fp)
	{			
		fwrite($fh, "HTTP Failure from Paypal", "An Http Failure from pay pal just occured now: \r\n$errno: $errstr"); //DEBUG		
	}	
	else
	{	
		fwrite($fh, "connected to:".($isSandbox)? $sandboxHost : $liveHost." $req \r\n"); //DEBUG		
		fputs($fp, $header.$req);
		
		while(!feof($fp))
		{			
			$res = fgets($fp, 1024);
						
			if(strcmp($res, "VERIFIED") == 0)
			{
				fwrite($fh, "confirmed VERIFIED \r\n"); //DEBUG
				
				if(strcmp($_POST['payment_status'], "Completed"))
				{
					fwrite($fh, "confirmed that payment_status is Completed");						
				}				
				
					
			}
			else if(strcmp($res, "INVALID") == 0)
			{
				fwrite($fh, "confirmed INVALID \r\n"); //DEBUG				
			}
		}
	}
	
	fclose($fp);	

	fclose($fh);
	
?>