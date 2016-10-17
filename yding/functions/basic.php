<?php
/**
 * AccessToken是企业访问钉钉开放平台接口的全局唯一票据，调用接口时需携带AccessToken。
 * AccessToken需要用CorpID和CorpSecret来换取，不同的CorpSecret会返回不同的AccessToken。正常情况下AccessToken有效期为7200秒，有效期内重复获取返回相同结果，并自动续期。
 * 
 * 通过定时执行access_token.php来获取
 * 
 * @throws YDing_Exception
 * @return string
 */
function yding_get_access_token() {
	$http = new YDingHttp ();
	$response = $http->get ( YDing_OAPI_HOST . '/gettoken', array (
			'corpid' => YDing_CORPID,
			'corpsecret' => YDing_SECRET 
	) );
	$response = json_decode ( $response );
	if ($response->access_token)
		return $response->access_token;
	throw new YDing_Exception ( $response->errmsg, $response->errcode );
}

/**
 * 本接口获取的SsoToken和上面获取的AccessToken应用场景不一样，SsoToken只在微应用后台管理免登服务中使用。
 * ISV开发的微应用后台免登中的SsoToken，使用ISV自己的corpid和ssosecret来换取，不是使用用户企业的
 * 
 * 通过定时执行sso_token.php来获取
 * 
 * @throws YDing_Exception
 * @return string
 */
function yding_get_sso_token() {
	$http = new YDingHttp ();
	$response = $http->get ( YDing_OAPI_HOST . '/sso/gettoken', array (
			'corpid' => YDing_ISV_CORPID,
			'corpsecret' => YDing_SSOSecret
	) );
	$response = json_decode ( $response );
	if ($response->access_token)
		return $response->access_token;
		throw new YDing_Exception ( $response->errmsg, $response->errcode );
}

/**
 * 获取当前页面的网页地址
 */
function yding_curr_page_url() {
	$pageURL = 'http';
	
	if (array_key_exists ( 'HTTPS', $_SERVER ) && $_SERVER ["HTTPS"] == "on") {
		$pageURL .= "s";
	}
	$pageURL .= "://";
	
	if ($_SERVER ["SERVER_PORT"] != "80") {
		$pageURL .= $_SERVER ["SERVER_NAME"] . ":" . $_SERVER ["SERVER_PORT"] . $_SERVER ["REQUEST_URI"];
	} else {
		$pageURL .= $_SERVER ["SERVER_NAME"] . $_SERVER ["REQUEST_URI"];
	}
	return $pageURL;
}

/**
 * sha1 签名
 * @param unknown $ticket
 * @param unknown $nonceStr
 * @param unknown $timeStamp
 * @param unknown $url
 */
function yding_sign($ticket, $nonceStr, $timeStamp, $url) {
	$plain = 'jsapi_ticket=' . $ticket . '&noncestr=' . $nonceStr . '&timestamp=' . $timeStamp . '&url=' . $url;
	return sha1 ( $plain );
}