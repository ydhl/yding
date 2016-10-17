<?php

$cwd = dirname ( __FILE__ );
require_once $cwd.'/yding/libs/ydinghook.php';

YDingHook::include_files($cwd."/yding/libs");

#
#
# 根据注册信息填写
#
#

//你hook钩子函数文件放置的目录
define("YDing_HOOK_DIR",             $cwd."/ydinghooks");

//你网站的地址,以/结尾，通过YDing_SITE_URL."yding/index.php"；需要能正确访问
define("YDing_SITE_URL",             "");


define('YDing_DIR_ROOT', dirname(__FILE__).'/');
define("YDing_OAPI_HOST", "https://oapi.dingtalk.com/");

//企业微应用配置
define("YDing_CORPID", "");
define("YDing_SECRET", "");
define("YDing_AGENTID", "");//必填，在创建微应用的时候会分配


//ISV配置()
define("YDing_CREATE_SUITE_KEY", "");
define("YDing_SUITE_KEY", "");
define("YDing_SUITE_SECRET", "");
define("YDing_TOKEN", "");
define("YDing_APPID", "");
define("YDing_ENCODING_AES_KEY", "");
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