<?php
/**
 * 该文件用于定时刷新dingding的相关 token；可配合ydtimer.yidianhulian.com或者其他定时器执行
 * 该刷新指处理宿主应用作为一个企业自建应用提供微服务和服务窗，及作为一个isv提供服务的情况，
 * 如果宿主应用是一个第三方托管平台，请自行处理所托管的企业的相关token刷新
 */

chdir(dirname(__FILE__));//把工作目录切换到文件所在目录
include_once dirname(__FILE__).'/../__config__.php';


if (YDing_CORPID){
	/**
	 * 刷新成功后会回调YDingHook::REFRESH_ACCESS_TOKEN
	 */
	
	//企业自建应用时刷新微应用 access token
	try{
		$access_token = yding_get_access_token(YDing_CORPID, YDing_CORPSECRET);
		YDingHook::do_hook(YDingHook::REFRESH_ACCESS_TOKEN, array(YDing_CORPID, $access_token));
	}catch (YDing_Exception $e){
		YDingHook::do_hook(YDingHook::EXCEPTION, $e);
	}
	
	//企业自建服务窗时刷新channel token
	try{
		$channel_token = yding_channel_get_token(YDing_CORPID, YDing_ChannelSecret);
		YDingHook::do_hook(YDingHook::REFRESH_CHANNEL_TOKEN, array(YDing_CORPID, $channel_token));
	}catch (YDing_Exception $e){
		YDingHook::do_hook(YDingHook::EXCEPTION, $e);
	}
	
	
	/**
	 * 刷新成功后会回调YDingHook::REFRESH_JS_API_TICKET
	 *
	 * 企业在使用微应用中的JS API时，需要先从钉钉开放平台接口获取jsapi_ticket生成签名数据，并将最终签名用的部分字段及签名结果返回到H5中，JS API底层将通过这些数据判断H5是否有权限使用JS API。
	 */
	try{
		$jsapi_ticket = yding_get_jsapi_ticket($access_token);
		YDingHook::do_hook(YDingHook::REFRESH_JS_API_TICKET, array(YDing_CORPID, $jsapi_ticket));
	}catch (YDing_Exception $e){
		YDingHook::do_hook(YDingHook::EXCEPTION, $e);
	}
	
	//企业服务窗的jsapiticket是那个？
	
	/**
	 * 刷新成功后会回调YDingHook::REFRESH_SSO_TOKEN.
	 * 本接口获取的SsoToken和AccessToken应用场景不一样，SsoToken只在微应用后台管理免登服务中使用。
	 * ISV开发的微应用后台免登中的SsoToken，使用ISV自己的corpid和ssosecret来换取，不是使用用户企业的
	 */
	try{
		$sso_token = yding_get_sso_token(YDing_CORPID, YDing_SSOSecret);
		YDingHook::do_hook(YDingHook::REFRESH_SSO_TOKEN, array(YDing_CORPID, $sso_token));
	}catch (YDing_Exception $e){
		YDingHook::do_hook(YDingHook::EXCEPTION, $e);
	}
}

//作为isv服务商时提
if (YDing_ISV_CORPID){
	// suite_access_token
	// 获取企业授权的access_token
	// 服务窗的channel token
	// jsapi ticket
	// sso_token
}

if (YDing_SNS_APPID){
	try{
		$sns_accesstoken = yding_sns_get_access_token(YDing_SNS_APPID, YDing_SNS_APP_SECRET);
		YDingHook::do_hook(YDingHook::REFRESH_SNS_ACCESS_TOKEN, array(YDing_SNS_APPID, $sns_accesstoken));
	}catch (YDing_Exception $e){
		YDingHook::do_hook(YDingHook::EXCEPTION, $e);
	}
}