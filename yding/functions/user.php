<?php

/**
 * 根据unionid获取成员的userid
 * 
 * @param unknown $accessToken
 * @param unknown $unionid 用户在当前钉钉开放平台账号范围内的唯一标识，同一个钉钉开放平台账号可以包含多个开放应用，同时也包含ISV的套件应用及企业应用
 * @return string
 */
function yding_get_userid_by_unionid($accessToken, $unionid){
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."user/getUseridByUnionid",
			array("access_token" => $accessToken, "unionid" => $unionid));
	$user = json_decode($response);
	if ($user->userid)return $user->userid;
	throw new YDing_Exception($user->errmsg, $user->errcode);
}

/**
 * 免登时，根据code获取用户信息
 * 企业应用的服务器在拿到CODE后，需要将CODE发送到钉钉开放平台接口，
 * 如果验证通过，则返回CODE对应的用户信息。**此接口只用于免登服务中用来换取用户信息**
 * 
 * @param unknown $accessToken
 * @param unknown $code
 * @return YDing_Base_User_Response
 */
function yding_get_User_Info($accessToken, $code)
{
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."user/getuserinfo",
			array("access_token" => $accessToken, "code" => $code));
	$user = new YDing_Base_User_Response($response);
	if ($user->isSuccess())return $user;
	throw new YDing_Exception($user->errmsg, $user->errcode);
}

/**
 * 获取成员详情
 * @param unknown $accessToken
 * @param string userid 员工在企业内的UserID，企业用来唯一标识用户的字段
 * @throws YDing_Exception
 * @return YDing_User_Detail_Response
 */
function yding_get_user_detail($accessToken, $userid){
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."user/get",
			array("access_token" => $accessToken, "userid" => $userid));
	$user = new YDing_User_Detail_Response($response);
	if ($user->isSuccess())return $user;
	throw new YDing_Exception($user->errmsg, $user->errcode);
}

/**
 * 微应用后台通过CODE换取微应用管理员的身份信息
 * 企业应用的服务器在拿到CODE后，需要将CODE发送到钉钉开放平台接口，
 * 如果验证通过，则返回CODE对应的管理员信息。**此接口只用于微应用后台管理员免登中用来换取管理员信息**
 * @param unknown $accessToken 再次强调，此token不同于一般的accesstoken，需要调用获取微应用管理员免登需要的AccessToken（sso token） 
 * @param unknown $code
 * @throws YDing_Exception
 * @return YDing_SSO_User_Response
 */
function yding_get_sso_user_Info($accessToken, $code)
{
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."sso/getuserinfo",
			array("access_token" => $accessToken, "code" => $code));
	$user = new YDing_SSO_User_Response($response);
	if ($user->isSuccess())return $user;
	throw new YDing_Exception($user->errmsg, $user->errcode);
}

/**
 * 获取部门列表 （ISV默认无调用权限）
 * 
 * @param unknown $accessToken
 * @throws YDing_Exception
 * @return array YDing_Department_Base
 */
function yding_get_departments($accessToken)
{
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."department/list",
			array("access_token" => $accessToken));
	$rst = json_decode($response);
	if ($rst->errcode!==0) throw new YDing_Exception($rst->errmsg, $rst->errcode);
	$array = array();
	foreach ($rst->department as $obj){
		$obj->errcode = $rst->errcode;
		$obj->errmsg = $rst->errmsg;
		$array[] = new YDing_Department_Base(json_encode($obj));
	}
	return $array;
}

/**
 * 获取部门详情 （ISV默认无调用权限）
 *
 * @param unknown $accessToken
 * @param unknown $id
 * @throws YDing_Exception
 * @return YDing_Department_Info
 */
function yding_get_department($accessToken, $id)
{
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."department/get",
			array("access_token" => $accessToken, "id"=>$id));
	$depart = new YDing_Department_Info($response);
	if ($depart->errcode!==0) throw new YDing_Exception($depart->errmsg, $depart->errcode);
	return $depart;
}

/**
 * 获取部门成员,返回简单信息
 * @param unknown YDing_Get_Department_User_Request
 * @return {hasMore:bool, userlist:[{userid:'',name:''}]}
 */
function yding_get_department_simple_users(YDing_Get_Department_User_Request $request){
	$http = new YDingHttp();
	$response = json_decode($http->get(YDing_OAPI_HOST."user/simplelist",$request->toArray()));
	if ($response->errcode !== 0) throw new YDing_Exception($response->errmsg, $response->errcode);
	return $response;

}
/**
 * 获取部门成员,返回详细信息
 * @param unknown YDing_Get_Department_User_Request
 * @return {hasMore:bool, userlist:[YDing_User_Detail_Response, YDing_User_Detail_Response]}
 */
function yding_get_department_users(YDing_Get_Department_User_Request $request){
	$http = new YDingHttp();
	$response = json_decode($http->Get(YDing_OAPI_HOST."user/list", $request->toArray()));
	if ($response->errcode !== 0) throw new YDing_Exception($response->errmsg, $response->errcode);
	$users = array();
	foreach ($response->userlist as $item){
		$item->errmsg  = $response->errmsg;
		$item->errcode = $response->errcode;
		
		$user = new YDing_User_Detail_Response(json_encode($item));
		$users[] = $user;
	}
	$response->userlist = $users;
	return $response;
}