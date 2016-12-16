<?php
/**
 * 是否是钉钉手机端
 * @return bool
 */
function yding_is_mobile(){
	return preg_match ( "/AliApp.+DingTalk/i", $_SERVER ['HTTP_USER_AGENT'] );
}
/**
 * 是否是钉钉桌面端
 * @return bool
 */
function yding_is_pc(){
	return preg_match ( "/DingTalk/i", $_SERVER ['HTTP_USER_AGENT'] );
}

/**
 * 输出钉钉扫码地址
 * @param $appid
 * @param $state 该数据会原样返回
 */
function yding_sns_qrcode_login_link($appid, $state){
	return "https://oapi.dingtalk.com/connect/qrconnect?appid={$appid}&response_type=code&scope=snsapi_login&state={$state}&redirect_uri="
			.urlencode(YDing_SITE_URL."yding/auth_sns.php");
}
/**
 * 普通钉钉用户账号开放相关接口和企业应用开发、ISV应用开发无关，第三方web服务提供商取得钉钉开放应用的appid及appsecret后，可以获取开放应用的ACCESS_TOKEN
 * @param string $appid
 * @param string $appsecret
 * @throws YDing_Exception
 * @return unknown
 */
function yding_sns_get_access_token($appid=YDing_SNS_APPID, $appsecret=YDing_SNS_APP_SECRET) {
	$http = new YDingHttp ();
	$response = $http->get ( YDing_OAPI_HOST . 'sns/gettoken', array (
			'appid' => $appid,
			'appsecret' => $appsecret
	) );
	$response = json_decode ( $response );
	if ($response->access_token)
		return $response->access_token;
		throw new YDing_Exception ( $response->errmsg, $response->errcode );
}

/**
 * 在获得钉钉用户的持久授权码后，通过以下接口获取该用户授权的SNS_TOKEN，此token的有效时间为2小时，重复获取不会续期。
 * 
 * @param unknown $access_token
 * @param unknown $persistent_code
 * @param unknown $openid
 * @throws YDing_Exception
 * @return unknown
 */
function yding_sns_get_sns_token($access_token, $persistent_code, $openid) {
	$http = new YDingHttp ();
	$response = $http->post ( YDing_OAPI_HOST . "sns/get_sns_token?access_token={$access_token}", json_encode(array (
			'openid' 		  => $openid,
			'persistent_code' => $persistent_code
	) ));
	$response = json_decode ( $response );
	if ($response->sns_token)
		return $response->sns_token;
		throw new YDing_Exception ( $response->errmsg, $response->errcode );
}

/**
 *  在获得钉钉用户的SNS_TOKEN后，获取该用户的个人信息
 * @param unknown $sns_token
 * @throws YDing_Exception
 * @return YDing_Sns_User_Response
 */
function yding_sns_get_user_info($sns_token) {
	$http = new YDingHttp ();
	$response = $http->get ( YDing_OAPI_HOST . "sns/getuserinfo", array (
			'sns_token' => $sns_token
	) );
	$response = new YDing_Sns_User_Response( $response );
	if ($response->isSuccess()) return $response;

	throw new YDing_Exception ( $response->errmsg, $response->errcode );
}


/**
 * 使用获取的SNS AccessToken及用户扫码中获取到的临时授权码code(tmp_auth_code)，
 * 调用下面的接口来获取当前钉钉用户授权给你的持久授权码。
 * 此授权码目前无过期时间，可反复使用，参数临时授权码code只能使用一次
 * 
 * @param unknown $access_token
 * @throws YDing_Exception
 * @return YDing_Sns_Persistent_Response
 */
function yding_sns_get_persistent_code($access_token, $code) {
	$http = new YDingHttp ();
	$response = $http->post ( YDing_OAPI_HOST . "sns/get_persistent_code?access_token={$access_token}", json_encode(array (
			'tmp_auth_code' => $code
	) ));
	$response = new YDing_Sns_Persistent_Response ( $response );
	if ($response->isSuccess()) return $response;
	
	throw new YDing_Exception ( $response->errmsg, $response->errcode );
}



/**
 * 获取js api ticket
 * 企业在使用微应用及服务窗中的JS API时，需要先从钉钉开放平台接口获取jsapi_ticket生成签名数据，
 * 并将最终签名用的部分字段及签名结果返回到H5中，JS API底层将通过这些数据判断H5是否有权限使用JS API。
 *
 * @param unknown $access_token
 * @return string
 * @throws YDing_Exception
 */
function yding_get_jsapi_ticket($access_token){
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST.'get_jsapi_ticket', array('type' => 'jsapi', 'access_token' => $access_token));
	$response = json_decode($response);
	if ($response->ticket) return $response->ticket;
	throw new YDing_Exception($response->errmsg, $response->errcode);
}


/**
 * 获取企业服务窗JSAPI鉴权ticket(企业自建或者isv提供都是该接口)，过期时间7200，需要通过ydtimer.yidianhulian.com或者其他定时访问refresh_token.php来定时刷新
 *
 * @param unknown $accessToken 企业服务窗接口访问凭证 即yding_get_channel_isv_token返回的内容，见refresh_token.php文件说明
 * @throws YDing_Exception
 * @return unknown
 */
function yding_get_channel_jsapi_ticket($accessToken){
	$http = new YDingHttp ();
	$response = $http->get ( YDing_OAPI_HOST . 'channel/get_channel_jsapi_ticket', array (
			'access_token' 		=> $accessToken
	) );

	$response = json_decode ( $response );
	if ($response->ticket)
		return $response->ticket;

		throw new YDing_Exception ( $response->errmsg, $response->errcode );
}

/**
 * AccessToken是企业自建微应用访问钉钉开放平台接口的全局唯一票据，调用接口时需携带AccessToken。
 * AccessToken需要用CorpID和CorpSecret来换取，不同的CorpSecret会返回不同的AccessToken。正常情况下AccessToken有效期为7200秒，有效期内重复获取返回相同结果，并自动续期。
 * 
 * 通过定时执行access_token.php来获取
 * 
 * @throws YDing_Exception
 * @return string
 */
function yding_get_access_token($corpid=YDing_CORPID, $corpsecret=YDing_CORPSECRET) {
	$http = new YDingHttp ();
	$response = $http->get ( YDing_OAPI_HOST . 'gettoken', array (
			'corpid' => $corpid,
			'corpsecret' => $corpsecret
	) );
	$response = json_decode ( $response );
	if ($response->access_token)
		return $response->access_token;
	throw new YDing_Exception ( $response->errmsg, $response->errcode );
}
/**
 * 获取套件访问Token（suite_access_token）
 * 使用场景
 * 该API用于获取应用套件令牌（suite_access_token）
 * @param $suite_key 应用套件的key
 * @param $suite_secret 应用套件secret
 * @param $suite_ticket 钉钉后台推送的ticket
 * @throws YDing_Exception
 * @return string
 */
function yding_get_suite_access_token($suite_key, $suite_secret, $suite_ticket) {
	$http = new YDingHttp ();
	$response = $http->post ( YDing_OAPI_HOST . 'service/get_suite_token', json_encode(array (
			'suite_key' 	=> $suite_key,
			'suite_secret'  => $suite_secret,
			'suite_ticket'  => $suite_ticket
	) ));
	$response = json_decode ( $response );
	if ($response->suite_access_token)
		return $response->suite_access_token;
		throw new YDing_Exception ( $response->errmsg, $response->errcode );
}
/**
 * 获取企业授权ISV的access_token
 * 使用场景
 * 服务提供商在取得企业的永久授权码并完成对企业应用的设置之后，便可以开始通过调用企业接口来运营这些应用。
 * 其中，调用企业接口所需的access_token获取方法如下接口说明。
 * 
 * @throws YDing_Exception
 * @return string 
 */
function yding_get_corp_access_token($suite_access_token, $auth_corpid, $permanent_code) {
	$http = new YDingHttp ();
	$response = $http->post ( YDing_OAPI_HOST . 'service/get_corp_token?suite_access_token='.$suite_access_token, json_encode(array (
			'auth_corpid' 	=> $auth_corpid,
			'permanent_code'=> $permanent_code
	) ));
	$response = json_decode ( $response );
	if ($response->access_token)
		return $response->access_token;
		throw new YDing_Exception ( $response->errmsg, $response->errcode );
}


/**
 * 本接口获取的SsoToken和上面获取的AccessToken应用场景不一样，SsoToken只在微应用后台管理免登服务中使用。
 * ISV开发的微应用后台免登中的SsoToken，使用ISV自己的corpid和ssosecret来换取，不是使用用户企业的
 * 
 * 
 * @throws YDing_Exception
 * @return string
 */
function yding_get_sso_token($corpid, $ssosecret) {
	$http = new YDingHttp ();
	$response = $http->get ( YDing_OAPI_HOST . 'sso/gettoken', array (
			'corpid' => $corpid,
			'corpsecret' => $ssosecret
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
		$pageURL .= $_SERVER ["SERVER_NAME"] . urldecode($_SERVER ["REQUEST_URI"]);
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

/**
 * 企业自建(也就是企业自己开发的)服务窗应用时获取服务窗ChannelToken.
 * 
 * 这里的channel token也是一种access token，过期时间7200，需要通过ydtimer.yidianhulian.com或者其他定时访问refresh_token.php来定时刷新
 * 
 * @throws YDing_Exception
 * @return string channelToken
 */
function yding_get_channel_token($corpid = YDing_CORPID, $channel_secret = YDing_ChannelSecret){
	$http = new YDingHttp ();
	$response = $http->get ( YDing_OAPI_HOST . 'channel/get_channel_token', array (
			'corpid' => $corpid,
			'channel_secret' => $channel_secret
	) );
	$response = json_decode ( $response );
	if ($response->access_token)
		return $response->access_token;
		
	throw new YDing_Exception ( $response->errmsg, $response->errcode );
}

/**
 * ISV获取企业服务窗接口调用channel TOKEN
 *
 * 这里的channel token也是一种access token，过期时间7200，需要通过ydtimer.yidianhulian.com或者其他定时访问refresh_token.php来定时刷新
 * @param $auth_corpid 授权方corpid
 * @param $ch_permanent_code 企业服务窗永久授权码
 * @throws YDing_Exception
 * @return string channelToken
 */
function yding_get_channel_isv_token($auth_corpid, $ch_permanent_code){
	$suite_access_token = YDingHook::do_hook(YDingHook::GET_SUITE_ACCESS_TOKEN);
	$http = new YDingHttp ();
	$response = $http->post ( YDing_OAPI_HOST . 'service/get_channel_corp_token?suite_access_token='.$suite_access_token, json_encode(array (
			'auth_corpid' 		=> $auth_corpid,
			'ch_permanent_code'	=> $ch_permanent_code
	) ));
	
	$response = json_decode ( $response );
	if ($response->access_token)
		return $response->access_token;

	throw new YDing_Exception ( $response->errmsg, $response->errcode );
}
