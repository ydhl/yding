<?php
/**
 * 获取服务窗关注者列表(外部联系人列表)
 * 
 * @param string $accessToken 服务窗专用ChannelToken
 * @param int $offset 偏移量,必须大于等于0
 * @param int $size 获取数量,大于等于0,小于等于100
 * @return YDing_Channel_Users_Response
 */
function yding_get_channel_users($accessToken, $offset=0, $size=20)
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
function yding_get_channel_user($accessToken, $openid)
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
function yding_get_channel_user_by_code($accessToken, $code)
{
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."channel/user/get_by_code",
			array("access_token" => $accessToken, "code" => $code));
	$user = new YDing_Channel_User_Base_Response($response);
	if ($user->isSuccess())return $user;
	throw new YDing_Exception($user->errmsg, $user->errcode);
}

