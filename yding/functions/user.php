<?php

/**
 * 免登时，根据code获取用户信息
 * 企业应用的服务器在拿到CODE后，需要将CODE发送到钉钉开放平台接口，
 * 如果验证通过，则返回CODE对应的用户信息。**此接口只用于免登服务中用来换取用户信息**
 * 
 * @param unknown $accessToken
 * @param unknown $code
 * @return YDing_Base_User_Response
 */
function yding_user_get_Info($accessToken, $code)
{
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."user/getuserinfo",
			array("access_token" => $accessToken, "code" => $code));
	$user = new YDing_Base_User_Response($response);
	if ($user->isSuccess())return $user;
	throw new YDing_Exception($user->errmsg, $user->errcode);
}

/**
 * 获取管理员列表
 *
 * @param unknown $accessToken
 * @return array(array(sys_level=>,userid=>))
 */
function yding_user_get_admins($accessToken)
{
    $http = new YDingHttp();
    $response = $http->get(YDing_OAPI_HOST."user/get_admin",
            array("access_token" => $accessToken));
    $rst = json_decode($response, true);
    if ($rst['errcode'] !==0) throw new YDing_Exception($rst['errmsg'], $rst['>errcode']);
    return $rst['adminList'];
}


/**
 * 获取成员详情
 * @param unknown $accessToken
 * @param string userid 员工在企业内的UserID，企业用来唯一标识用户的字段
 * @throws YDing_Exception
 * @return YDing_User_Detail_Response
 */
function yding_user_get_detail($accessToken, $userid){
	$http = new YDingHttp();
	$response = $http->get(YDing_OAPI_HOST."user/get",
			array("access_token" => $accessToken, "userid" => $userid));
	$user = new YDing_User_Detail_Response($response);
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
function yding_department_get_all($accessToken)
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
 * 创建部门 （ISV默认无调用权限）
 *
 * @param unknown $accessToken
 * @param YDing_Department_Create_Request $depart
 * @throws YDing_Exception
 * @return dingdingid
 */
function yding_department_create($accessToken, YDing_Department_Save_Request $depart)
{
    $http = new YDingHttp();
    $response = $http->post(YDing_OAPI_HOST."department/create?access_token={$accessToken}",
    $depart->toJSONString());
    $rst = json_decode($response);
    if ($rst->errcode!==0) throw new YDing_Exception($rst->errmsg, $rst->errcode);
    return $rst->id;
}

/**
 * 创建成员接口说明（ISV默认无调用权限）
 * 
 * 本接口属高权限接口，调用会被严格限制。请管理员在调用前完成个人实名认证，或者提交企业认证，人数上限将自动扩充。
 * @param unknown $accessToken
 * @param YDing_User_Save_Request $depart
 * @throws YDing_Exception
 * @return dinding
 */
function yding_user_create($accessToken, YDing_User_Save_Request $user)
{
    $http = new YDingHttp();
    $response = $http->post(YDing_OAPI_HOST."user/create?access_token={$accessToken}",
    $user->toJSONString());
    $rst = json_decode($response);
    if ($rst->errcode!==0) throw new YDing_Exception($rst->errmsg, $rst->errcode);
    return $rst->userid;
}
/**
 * 更新成员接口说明（ISV默认无调用权限）
 *
 * @param unknown $accessToken
 * @param YDing_User_Save_Request $depart
 * @throws YDing_Exception
 * @return bool
 */
function yding_user_update($accessToken, YDing_User_Save_Request $user)
{
    $http = new YDingHttp();
    $response = $http->post(YDing_OAPI_HOST."user/update?access_token={$accessToken}",
    $user->toJSONString());
    $rst = json_decode($response);
    if ($rst->errcode!==0) throw new YDing_Exception($rst->errmsg, $rst->errcode);
    return true;
}
/**
 * 删除成员接口说明（ISV默认无调用权限）
 *
 * @param unknown $accessToken
 * @param $userid 员工唯一标识ID（不可修改）
 * @throws YDing_Exception
 * @return bool
 */
function yding_user_delete($accessToken, $userid)
{
    $http = new YDingHttp();
    $response = $http->get(YDing_OAPI_HOST."user/delete?access_token={$accessToken}&userid={$userid}");
    $rst = json_decode($response);
    if ($rst->errcode!==0) throw new YDing_Exception($rst->errmsg, $rst->errcode);
    return true;
}
/**
 * 批量删除成员接口说明（ISV默认无调用权限）
 *
 * @param unknown $accessToken
 * @param $userids 员工唯一标识ID（不可修改）
 * @throws YDing_Exception
 * @return bool
 */
function yding_user_delete_batch($accessToken, $userids)
{
    $http = new YDingHttp();
    $response = $http->post(YDing_OAPI_HOST."user/batchdelete?access_token={$accessToken}", 
    json_encode(array("useridlist"=>$userids)));
    $rst = json_decode($response);
    if ($rst->errcode!==0) throw new YDing_Exception($rst->errmsg, $rst->errcode);
    return true;
}
/**
 * 删除部门 （ISV默认无调用权限）
 *
 * @param unknown $accessToken
 * @param depart_id 部门id。（注：不能删除根部门；不能删除含有子部门、成员的部门）
 * @throws YDing_Exception
 * @return bool
 */
function yding_department_delete($accessToken, $depart_id)
{
    $http = new YDingHttp();
    $response = $http->get(YDing_OAPI_HOST."department/delete?access_token={$accessToken}&id={$depart_id}");
    $rst = json_decode($response);
    if ($rst->errcode!==0) throw new YDing_Exception($rst->errmsg, $rst->errcode);
    return true;
}

/**
 * 更新部门 （ISV默认无调用权限）
 *
 * @param unknown $accessToken
 * @param YDing_Department_Create_Request $depart
 * @throws YDing_Exception
 * @return bool
 */
function yding_department_update($accessToken, YDing_Department_Save_Request $depart)
{
    $http = new YDingHttp();
    $response = $http->post(YDing_OAPI_HOST."department/update?access_token={$accessToken}",
    $depart->toJSONString());
    $rst = json_decode($response);
    if ($rst->errcode!==0) throw new YDing_Exception($rst->errmsg, $rst->errcode);
    return true;
}

/**
 * 获取部门详情 （ISV默认无调用权限）
 *
 * @param unknown $accessToken
 * @param unknown $id
 * @throws YDing_Exception
 * @return YDing_Department_Info
 */
function yding_department_get($accessToken, $id)
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
 * @param unknown YDing_Department_Get_User_Request
 * @return {hasMore:bool, userlist:[{userid:'',name:''}]}
 */
function yding_department_get_simple_users(YDing_Department_Get_User_Request $request){
	$http = new YDingHttp();
	$response = json_decode($http->get(YDing_OAPI_HOST."user/simplelist",$request->toArray()));
	if ($response->errcode !== 0) throw new YDing_Exception($response->errmsg, $response->errcode);
	return $response;

}
/**
 * 获取部门成员,返回详细信息
 * @param unknown YDing_Department_Get_User_Request
 * @return {hasMore:bool, userlist:[YDing_User_Detail_Response, YDing_User_Detail_Response]}
 */
function yding_department_get_users(YDing_Department_Get_User_Request $request){
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