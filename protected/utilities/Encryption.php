<?php

class Encryption {
	/**	 
	 * encrypts a string with the supplied key
	 * @param string $string
	 * @param string $key
	 */
	function encryptData($string, $key) {  
 	  $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);  
  	  $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);  
  	  return base64_encode(mcrypt_encrypt(MCRYPT_3DES, $key, $string, MCRYPT_MODE_ECB, $iv));  
	}  
  
	/**	 
	 * Decrypts a string with the supplied key
	 * @param string $string
	 * @param string $key
	 */
	function decryptData($string, $key) {  
   	 $iv_size = mcrypt_get_iv_size(MCRYPT_3DES, MCRYPT_MODE_ECB);  
   	 $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);  
   	 return trim(mcrypt_decrypt(MCRYPT_3DES, $key, base64_decode($string), MCRYPT_MODE_ECB, $iv));  
	}  

}

?>