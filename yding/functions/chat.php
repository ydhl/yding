<?php
/**
 * 会话管理接口
 */

/**
 * 创建群会话
 * @param $accessToken
 * @param YDing_Chat_Create_Request
 * @throws YDing_Exception
 * @return YDing_Chat_Create_Response
 */
function yding_chat_create($accessToken, YDing_Chat_Create_Request $request) {
	$http = new YDingHttp();
	$response = $http->post(YDing_OAPI_HOST. "chat/create?access_token=".$accessToken,   $request->toJSONString() );
	$obj = new YDing_Chat_Create_Response($response);
	if ($obj->isSuccess()) return $obj;
	throw new YDing_Exception($obj->errmsg, $obj->errcode);
}

/**
 * 绑定微应用和群会话
 * @param unknown $accessToken
 * @param unknown $chatid
 * @param unknown $agentid 微应用agentId，每个群最多绑定5个微应用，一个群只能被一个ISV套件绑定一次
 * @throws YDing_Exception
 * @return boolean
 */
function yding_chat_bind($accessToken, $chatid, $agentid) {
	$http = new YDingHttp();
	$response = $http->get( YDing_OAPI_HOST."chat/bind", array (
			"access_token" => $accessToken,
			"chatid" => $chatid,
			"agentid" => $agentid 
	) );
	$obj = json_decode($response);
	if ($obj->errcode===0) return true;
	throw new YDing_Exception($obj->errmsg, $obj->errcode);
}
/**
 * 解绑微应用和群会话
 * @param unknown $accessToken
 * @param unknown $chatid
 * @param unknown $agentid 微应用agentId
 * @throws YDing_Exception
 * @return boolean
 */
function yding_chat_unbind($accessToken, $chatid, $agentid) {
	$http = new YDingHttp();
	$response = $http->get( YDing_OAPI_HOST."chat/unbind", array (
			"access_token" => $accessToken,
			"chatid" => $chatid,
			"agentid" => $agentid
	) );
	$obj = json_decode($response);
	if ($obj->errcode===0) return true;
	throw new YDing_Exception($obj->errmsg, $obj->errcode);
}
/**
 * 发送消息到群会话
 * @param unknown $accessToken
 * @param YDing_Chat_Sendmsg_Request $request
 * @throws YDing_Exception
 * @return boolean
 */
function yding_chat_sendmsg($accessToken, YDing_Chat_Sendmsg_Request $request) {
	$http = new YDingHttp();
	$response = $http->post( YDing_OAPI_HOST."chat/send?access_token={$accessToken}", $request->toJSONString() );
	
	$obj = json_decode($response);
	if ($obj->errcode===0) return true;
	throw new YDing_Exception($obj->errmsg, $obj->errcode);
}

/**
 * 发送企业消息。企业可以主动发消息给员工，消息量不受限制。
 * 发送企业会话消息和发送普通会话消息的不同之处在于发送消息的主体不同
 * 
 * - 普通会话消息发送主体是普通员工，体现在接收方手机上的联系人是消息发送员工
 * 
 * - 企业会话消息发送主体是企业，体现在接收方手机上的联系人是你填写的agentid对应的微应用
 * @param unknown $accessToken
 * @param YDing_Crop_Sendmsg_Request $request
 * @throws YDing_Exception
 * @return YDing_Crop_Sendmsg_Response
 */
function yding_crop_sendmsg($accessToken, YDing_Crop_Sendmsg_Request $request) {
	$http = new YDingHttp();
	$response = $http->post( YDing_OAPI_HOST."message/send?access_token={$accessToken}", $request->toJSONString() );
	$obj = new YDing_Crop_Sendmsg_Response($response);
	if ($obj->isSuccess()) return $obj;
	throw new YDing_Exception($obj->errmsg, $obj->errcode);
}