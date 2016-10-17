<?php
/**
 * 该文件用于定时刷新dingding微应用后台管理免登sso token；可配合ydtimer.yidianhulian.com或者其他定时器执行
 * 刷新成功后会回调YDingHook::REFRESH_SSO_TOKEN.
 * 本接口获取的SsoToken和AccessToken应用场景不一样，SsoToken只在微应用后台管理免登服务中使用。
 * ISV开发的微应用后台免登中的SsoToken，使用ISV自己的corpid和ssosecret来换取，不是使用用户企业的
 */

chdir(dirname(__FILE__));//把工作目录切换到文件所在目录
include_once dirname(__FILE__).'/../__config__.php';

try{
	$access_token = yding_get_sso_token();
	YDingHook::do_hook(YDingHook::REFRESH_SSO_TOKEN, $access_token);
}catch (YDing_Exception $e){
	YDingHook::do_hook(YDingHook::EXCEPTION, $e);
}
