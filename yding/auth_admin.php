<?php 
/**
 * 该文件是钉钉企业自建微应用后台的免登处理地址，点击微应用的“进入”边登录系统
 *
 * 免登成功后，触发YDingHook::AUTH_SUCCESS；
 * 免登失败，触发YDingHook::AUTH_FAIL；
 * 
 * @author leeboo@yidianhulian.com
 */

chdir(dirname(__FILE__));//把工作目录切换到文件所在目录
include_once dirname(__FILE__).'/../__config__.php';

try{
	if( ! @$_GET["code"]){
		throw new YDing_Exception("code is missing");
	}
	
	//TODO 考虑ISV的处理
	$sso_token = YDingHook::do_hook(YDingHook::GET_SSO_TOKEN, array(YDing_CORPID));
	if( ! $sso_token){
		$sso_token = yding_get_sso_token(YDing_CORPID, YDing_SSOSecret);
		YDingHook::do_hook(YDingHook::REFRESH_SSO_TOKEN, array(YDing_CORPID, $sso_token));
	}
	
	$user = yding_get_sso_user_Info($sso_token, $_GET["code"]);
	$access_token = YDingHook::do_hook(YDingHook::GET_ACCESS_TOKEN, YDing_CORPID);
	
	if ( ! $access_token){
		$access_token = yding_get_access_token(YDing_CORPID, YDing_CORPSECRET);
		YDingHook::do_hook(YDingHook::REFRESH_ACCESS_TOKEN, array(YDing_CORPSECRET, $access_token));
	}
// 	var_dump($user);
	$user = yding_user_get_detail($access_token, $user->userid);
	YDingHook::do_hook(YDingHook::AUTH_SUCCESS, $user);
}catch (\Exception $e){
	YDingHook::do_hook(YDingHook::EXCEPTION, $e);
	YDingHook::do_hook(YDingHook::AUTH_FAIL, $e->getMessage());
	die();
}
?>