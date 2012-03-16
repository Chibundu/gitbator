<?php
$yii = dirname ( __FILE__ ) . '/../yii/framework/yiilite.php';
$config = dirname ( __FILE__ ) . '/protected/config/main.php';

require_once ($yii);

$app = Yii::createWebApplication ( $config );

$payment_id = 0;
if(isset($_GET ['payment_id']))
	$payment_id = $_GET ['payment_id'];
	
$enc = new Encryption ();
$payment_id = $enc->decryptData ( urldecode ($payment_id ), Yii::app ()->params ['enc_key'] );

$payment = Payments::model ()->findByPk ( $payment_id );
$currencies = Currencies::model();
if ($payment) {
	
	$isSandbox = false;
	$sandboxHost = 'ssl://www.sandbox.paypal.com';
	
	$fh = fopen ( "paypal_success_debug.txt", "w" );
	
	$liveHost = 'ssl://www.paypal.com';
	if (isset ( $_GET ['sandbox'] ) && $_GET ['sandbox'] == '1') {
		$isSandbox = true;
	}
	
	// read the post from PayPal system and add 'cmd'
	$req = 'cmd=_notify-synch';
	
	$tx_token = $_GET ['tx'];
	$auth_token = "72nkPSxEyoYSfj9v34SKKaGczeJfkLSdOi3UIB1U1saCYaiou92vRfQUFTO";
	$req .= "&tx=$tx_token&at=$auth_token";
	
	//post back to PayPal system to validate
	$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
	$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
	$header .= "Content-Length: " . strlen ( $req ) . "\r\n\r\n";
	
	$fp = fsockopen ( (($isSandbox) ? $sandboxHost : $liveHost), 443, $errno, $errstr, 30 );
	
	if (! $fp) {		
		fwrite ( $fh, "\r\n$errno: $errstr\r\n" );
	} else {
		fputs ( $fp, $header . $req );
		// read the body data 
		$res = '';
		$headerdone = false;
		while ( ! feof ( $fp ) ) {			
			$line = fgets ( $fp, 1024 );
			if (strcmp ( $line, "\r\n" ) == 0) {
				// read the header
				$headerdone = true;
			} else if ($headerdone) {
				// header has been read. now read the contents
				$res .= $line;
			}
		}
		
		// parse the data
		$lines = explode ( "\n", $res );
		$keyarray = array ();			 
	
		if (strcmp ( $lines [0], "SUCCESS" ) == 0) {	
					
			for($i = 1; $i < count ( $lines ); $i ++) {
				list ( $key, $val ) = explode ( "=", $lines [$i] );
				$keyarray [urldecode ( $key )] = urldecode ( $val );
			}
			$payment->for = $keyarray['item_name'];
			$payment->gt_id = $keyarray['txn_id'];
			$paymentEvent = new PaymentEvent($payment);
			$paymentEvent->controller = new Controller('payment');
			$pt = Yii::app()->paymentTransaction;
						
			if($payment->gt_id != NULL && $payment->gt_id != $keyarray['txn_id'])
			{
				$paymentEvent->error = "Sorry, we cannot confirm your payment at this time!";
				$pt->paymentError($paymentEvent);
			}
			
		
						
			// check the payment_status is Completed			
			if(strcmp($keyarray['payment_status'], 'Completed') == 0)
			{				
				//verify that the amount is correct
				if(floatval($payment->amount) == floatval($keyarray['payment_gross'])){
					
					$pt->paymentComplete($paymentEvent);
				}
				else
				{			
					
					$cl = $keyarray['mc_currency'];
					$currency_symbol = trim($currencies->findByAttributes(array('literal'=>$cl))->symbol);
					$currency_symbol = ($currency_symbol)? $currency_symbol :'';
					$paymentEvent->error = "We have been notified that you paid $currency_symbol".$keyarray['payment_gross']." instead of the required $currency_symbol".
					$payment->amount.". Our financial team will be contacting you in 24 - 48 hrs on how you intend for this issue to be resolved";
					$pt->paymentError($paymentEvent);					
				}	
			}			
			else if(strcmp($keyarray['payment_status'], 'Fail') == 0)
			{
				$pt->paymentFail ($paymentEvent);
			}
			else
			{
				$pt->paymentNotYetReceived($paymentEvent);
			}
			
			// check that txn_id has not been previously processed
			// check that receiver_email is your Primary PayPal email
			// check that payment_amount/payment_currency are correct
			// process payment
			$firstname = $keyarray ['first_name'];
			$lastname = $keyarray ['last_name'];
			$itemname = $keyarray ['item_name'];
			$amount = $keyarray ['payment_gross'];
		
		} else if (strcmp ( $lines [0], "FAIL" ) == 0) {
			// log for manual investigation
			
		}
		
		header("location: http://thevcubator.com/".$payment->url_stack);
		
		
	
	}
	
	fclose ( $fp );
}