<?php
/**
 * 该文件用于定时刷新dingding的企业自建服务窗应用channel token token；可配合ydtimer.yidianhulian.com或者其他定时器执行
 * 刷新成功后会回调YDingHook::REFRESH_CHANNEL_TOKEN
 */

chdir(dirname(__FILE__));//把工作目录切换到文件所在目录
include_once dirname(__FILE__).'/../__config__.php';

try{
	$access_token = yding_get_channel_token();
	YDingHook::do_hook(YDingHook::REFRESH_CHANNEL_TOKEN, $access_token);
}catch (YDing_Exception $e){
	YDingHook::do_hook(YDingHook::EXCEPTION, $e);
}
