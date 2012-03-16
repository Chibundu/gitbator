<?php

/** 
 * @author WORKSTATION
 * 
 * 
 */
class Clickatell {
	var $username;
	var $password;
	var $api_id;
	var $url = 'http://api.clickatell.com/http/sendmsg';
	var $postFields;
	
	
	/**	 
	 * constructs a new Clickatell object with the supplied authentication parameters
	 * @param string $username
	 * @param string $password
	 * @param string $api_id
	 */
	public function __construct($username, $password, $api_id)
	{
		$this->username = $username;
		$this->password = $password;
		$this->api_id = $api_id;
		$this->postFields = 'api_id='.$api_id.'&user='.$username.'&password='.$password.'&to=xxxx&text=xxxx';
	}
	/**	 
	 * Sends SMS to a Single Phone number
	 * @param string $recipient the recipient phone number
	 * @param string $text the text message
	 */
	public function sendSingleSMS($recipient, $text)
	{
		$this->postFields = str_replace('to=xxxx', 'to='.$recipient, $this->postFields);
		$this->postFields = str_replace('text=xxxx', 'text='.urlencode($text), $this->postFields);	
		
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $this->postFields);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response = curl_exec($ch);
		curl_close($ch);
		
		 if(strpos($response, 'ID')!==false)
		 {
		 	return true;
		 }
		 else
		 {
		 	return false;
		 }
	}


}

?>