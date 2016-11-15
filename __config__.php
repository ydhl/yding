<?php

$cwd = dirname ( __FILE__ );
require_once $cwd.'/yding/libs/ydinghook.php';

YDingHook::include_files($cwd."/yding/libs");

//你hook钩子函数文件放置的目录
define("YDing_HOOK_DIR",	$cwd."/ydinghooks");
define('YDing_DIR_ROOT', 	dirname(__FILE__).'/');
define("YDing_OAPI_HOST",	"https://oapi.dingtalk.com/");//注意，要以/结尾

#
#
# 根据注册信息填写
#
#

//你网站的地址,以/结尾，通过YDing_SITE_URL."yding/index.php"；需要能正确访问
define("YDing_SITE_URL",             "");

//企业微应用配置
define("YDing_CORPID", "");
define("YDing_CORPSECRET", "");
define("YDing_ChannelSecret","");
define("YDing_SSOSecret", "");
define("YDing_TOKEN", "");//注册事件回调接口token，任意填写，注意保密
define("YDing_ENCODING_AES_KEY", "");//注册事件回调接口的数据加密密钥(ENCODING_AES_KEY)，任意填写，注意保密

//SNS网站配置
define("YDing_SNS_APPID", 		"");
define("YDing_SNS_APP_SECRET", 	"");

//作为ISV配置
define("YDing_ISV_CORPID", "");
define("YDing_ISV_SSOSecret", "");
define("YDing_ISV_TOKEN", "");//创建套件时填写的token，任意填写，注意保密
define("YDing_ISV_ENCODING_AES_KEY", "");//创建套件时填写的数据加密密钥(ENCODING_AES_KEY)，任意填写，注意保密
#
#
# 填写结束
#
#


YDingHook::include_files($cwd."/yding/models");
YDingHook::include_files($cwd."/yding/functions");//包含功能函数库

#加载你自己的hook目录
YDingHook::include_files(YDing_HOOK_DIR);

?>