<?php 
/**
 * 该文件是sns网站扫码后的回调页面
 * 
 * 免登成功后，触发YDingHook::AUTH_SUCCESS；
 * 免登失败，触发YDingHook::AUTH_FAIL；
 */

chdir(dirname(__FILE__));//把工作目录切换到文件所在目录
include_once dirname(__FILE__).'/../__config__.php';
try{
	if ( ! $_GET["code"]){
		throw new YDing_Exception("code is missing");
	}
	
	$access_token = YDingHook::do_hook(YDingHook::GET_SNS_ACCESS_TOKEN, YDing_SNS_APPID);
	
	if ( ! $access_token){
		$access_token = yding_sns_get_access_token(YDing_SNS_APPID, YDing_SNS_APP_SECRET);
		YDingHook::do_hook(YDingHook::REFRESH_SNS_ACCESS_TOKEN, array(YDing_SNS_APPID, $access_token));
	}
	
	$persistent = yding_sns_get_persistent_code($access_token, $_GET["code"]);
	
	$sns_token = yding_sns_get_sns_token($access_token, $persistent->persistent_code, $persistent->openid);
	
	$user = yding_sns_get_user_info($sns_token);
	YDingHook::do_hook(YDingHook::AUTH_SUCCESS, $user);
}catch (YDing_Exception $e){
	YDingHook::do_hook(YDingHook::EXCEPTION, $e);
	YDingHook::do_hook(YDingHook::AUTH_FAIL, $e->getMessage());
	die();
}

?>