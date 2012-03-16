<?php	
	
$yii=dirname(__FILE__).'/../yii/framework/yiilite.php';
$config=dirname(__FILE__).'/protected/config/main.php';

require_once($yii);

$isSandbox = false;
$sandboxHost = 'ssl://www.sandbox.paypal.com';

$fh = fopen("paypal_notify_debug.txt", "w");

$liveHost = 'ssl://www.paypal.com';
if(isset($_GET['sandbox']) && $_GET['sandbox'] == '1'){
	$isSandbox = true;
}

$app = Yii::createWebApplication($config);

$payment_id = CHtml::encode($_GET['payment_id']);
$payment = Payments::model()->findByPk($payment_id);

if($payment)
{
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
	
	foreach ($_POST as $key=>$value)
	{
		if($key == 'test_ipn' && $value == '1')
		{
			$isSandbox = true;
		}
		$req.="&$key=". (($isMagicQuotesOn) ? urlencode(stripslashes($value)) : urlencode($value));	
	}
	
	fwrite($fh, "post variables: $req \r\n"); //DEBUG
	
	$header  = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: x-www-form-urlencoded\r\n";
	$header .= "Content-Length:".strlen($req)."\r\n\r\n";	
	
	$fp = fsockopen(($isSandbox)? $sandboxHost : $liveHost, 443, $errno, $errstr, 30);
	
	if(!$fp)
	{			
		mail("mbagwu.c@gmail.com", "HTTP Failure from Paypal", "An Http Failure from pay pal just occured now: \r\n$errno: $errstr");
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
				$payment->status = Payments::COMPLETED;
				
			/*	– Confirm that the payment status is Completed.
				PayPal sends IPN messages for pending and denied payments as well; do not ship until
				the payment has cleared.
				– Use the transaction ID to verify that the transaction has not already been processed,
				which prevents duplicate transactions from being processed.
				Typically, you store transaction IDs in a database so that you know you are only
				processing unique transactions.
				– Validate that the receiver’s email address is registered to you.
				This check provides additional protection against fraud.
				– Verify that the price, item description, and so on, match the transaction on your website.
				This check provides additional protection against fraud*/
				
				if(strcmp($_POST['payment_status'], "Completed"))
				{
					fwrite($fh, "confirmed that payment_status is Completed");
					$payment->save(false);	
				}				
				
					
			}
			else if(strcmp($res, "INVALID") == 0)
			{
				fwrite($fh, "confirmed INVALID \r\n"); //DEBUG
				$payment->status = Payments::FAILED;
				$payment->save(false);
			}
		}
	}
	
	fclose($fp);	
}
	fclose($fh);
	
?>