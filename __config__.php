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
define("YDing_SECRET", "");
define("YDing_ChannelSecret","");

//ISV配置
define("YDing_SUITE_ACCESS_TOKEN", "");//isv 开发套件ACCESSTOKEN
define("YDing_SSOSecret", "");
define("YDing_ISV_CORPID", "");

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