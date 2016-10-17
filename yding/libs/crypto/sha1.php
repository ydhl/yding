<?php

class YDingSHA1
{
	public function getSHA1($token, $timestamp, $nonce, $encrypt_msg)
	{
		try {
			$array = array($encrypt_msg, $token, $timestamp, $nonce);
			sort($array, SORT_STRING);
			$str = implode($array);
			return array(YDingErrorCode::$OK, sha1($str));
		} catch (Exception $e) {
			print $e . "\n";
			return array(YDingErrorCode::$ComputeSignatureError, null);
		}
	}

}


?>