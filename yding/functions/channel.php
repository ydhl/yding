<?php
/**
 * 获取服务窗关注者列表(外部联系人列表)
 * 
 * @param string $accessToken 服务窗专用ChannelToken
 * @param int $offset 偏移量,必须大于等于0
 * @param int $size 获取数量,大于等于0,小于等于100
 * @return YDing_Channel_Users_Response
 */
function yding_channel_get_users($accessToken, $offset=0, $size=20)
{
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."channel/user/list",
			array("access_token" => $accessToken, "offset" => $offset, "size" => $size));
	$users = new YDing_Channel_Users_Response($response);
	if ($users->isSuccess())return $users;
	throw new YDing_Exception($users->errmsg, $users->errcode);
}

/**
 * 获取关注者详情
 * @param unknown $accessToken 服务窗专用ChannelToken
 * @param number $openid
 * @throws YDing_Exception
 * @return YDing_Channel_User_Response
 */
function yding_channel_get_user($accessToken, $openid)
{
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."channel/user/get_by_openid",
			array("access_token" => $accessToken, "openid" => $openid));
	$user = new YDing_Channel_User_Response($response);
	if ($user->isSuccess())return $user;
	throw new YDing_Exception($user->errmsg, $user->errcode);
}

/**
 * 关注者免登接口, 通过临时授权码code获取用户详情
 * @param unknown $accessToken 服务窗专用ChannelToken
 * @param unknown $code 服务窗关注者在服务窗应用中免登时生成的临时授权码
 * @throws YDing_Exception
 * @return YDing_Channel_User_Base_Response
 */
function yding_channel_get_user_by_code($accessToken, $code)
{
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."channel/user/get_by_code",
			array("access_token" => $accessToken, "code" => $code));
	$user = new YDing_Channel_User_Base_Response($response);
	if ($user->isSuccess())return $user;
	throw new YDing_Exception($user->errmsg, $user->errcode);
}


/**
 * 企业自建(也就是企业自己开发的)服务窗应用时获取服务窗ChannelToken.
 *
 * 这里的channel token也是一种access token，过期时间7200，需要通过ydtimer.yidianhulian.com或者其他定时访问refresh_token.php来定时刷新
 *
 * @throws YDing_Exception
 * @return string channelToken
 */
function yding_channel_get_token($corpid = YDing_CORPID, $channel_secret = YDing_ChannelSecret){
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
function yding_channel_get_isv_token($auth_corpid, $ch_permanent_code){
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



/**
 * 获取企业服务窗JSAPI鉴权ticket(企业自建或者isv提供都是该接口)，过期时间7200，需要通过ydtimer.yidianhulian.com或者其他定时访问refresh_token.php来定时刷新
 *
 * @param unknown $accessToken 企业服务窗接口访问凭证 即yding_get_channel_isv_token返回的内容，见refresh_token.php文件说明
 * @throws YDing_Exception
 * @return unknown
 */
function yding_channel_get_jsapi_ticket($accessToken){
    $http = new YDingHttp ();
    $response = $http->get ( YDing_OAPI_HOST . 'channel/get_channel_jsapi_ticket', array (
            'access_token' 		=> $accessToken
    ) );

    $response = json_decode ( $response );
    if ($response->ticket)
        return $response->ticket;

        throw new YDing_Exception ( $response->errmsg, $response->errcode );
}