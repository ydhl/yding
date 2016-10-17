<?php
/**
 * 该文件实现PC免登服务，把该页面作为应用的登录验证页面；
 * 免登成功后，页面跳转指SSO_REDIRECT_SUCCESS指定的地址；
 * 免登失败，页面跳转指SSO_REDIRECT_FAIL指定的地址；
 */

chdir(dirname(__FILE__));//把工作目录切换到文件所在目录
include_once dirname(__FILE__).'/../__config__.php';

try{
	if ( @ $_GET["error"]){
		YDingHook::do_hook(YDingHook::AUTH_FAIL, $_GET["error"]);
		die();
	}
	$access_token = YDingHook::do_hook(YDingHook::GET_ACCESS_TOKEN);


	if ( ! $access_token){
		$access_token = yding_get_access_token();
		YDingHook::do_hook(YDingHook::REFRESH_ACCESS_TOKEN, $access_token);
	}


	if ( @ $_GET["code"]){
		$userinfo = yding_get_User_Info($access_token, $_GET["code"]);
		YDingHook::do_hook(YDingHook::AUTH_SUCCESS, $userinfo);
		die();
	}

	$jsapi_ticket = YDingHook::do_hook(YDingHook::GET_JS_API_TICKET);
	if ( ! $jsapi_ticket){
		//有可能jsapi_ticket.php没有配置执行或者得到的jsapi_ticket没有存储下来，
		//这里重新执行一次获取jsapi ticket
		$jsapi_ticket = yding_get_js_ticket($access_token);
		YDingHook::do_hook(YDingHook::REFRESH_JS_API_TICKET, $jsapi_ticket);
	}

	$nonceStr = uniqid();
	$timeStamp = time();
	$url 		= yding_curr_page_url ();
	$signature = yding_sign($jsapi_ticket, $nonceStr, $timeStamp, $url);

}catch (YDing_Exception $e){
	YDingHook::do_hook(YDingHook::EXCEPTION, $e);
	YDingHook::do_hook(YDingHook::AUTH_FAIL, $e->getMessage());
	die();
}

?>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>登录中...</title>
		<?php yding_pc_jsapi_init();?>
		<script type="text/javascript">
		DingTalkPC.config({
			agentId: "<?php echo YDing_AGENTID?>",
		    corpId:  "<?php echo YDing_CORPID?>",
		    timeStamp: "<?php echo $timeStamp?>",
		    nonceStr: "<?php echo $nonceStr?>",
		    signature: "<?php echo $signature?>",
		    jsApiList: [
		        'runtime.permission.requestAuthCode',
		        'device.notification.alert',
		        'device.notification.confirm',
		        'biz.contact.choose',
		        'device.notification.prompt',
		        'biz.ding.post'
		        ] // 必填，需要使用的jsapi列表
		});
		DingTalkPC.userid=0;
		DingTalkPC.ready(function(res){
		    DingTalkPC.runtime.permission.requestAuthCode({
			    corpId: "<?php echo YDing_CORPID?>", //企业id
		        onSuccess: function (info) {
		        	//console.log('authcode: ' + info.code);
		        	window.location.href = "<?php echo $url?>?code="+info.code;
		        },
		        onFail: function (err) {
		        	//console.log('requestAuthCode fail: ' + JSON.stringify(err));
		        	window.location.href = "<?php echo $url?>?error="+JSON.stringify(err);
		        }
		    });
		});
		DingTalkPC.error(function(err) {
			//console.log('dd error: ' + JSON.stringify(err));
			window.location.href = "<?php echo $url?>?error="+JSON.stringify(err);
		});
		</script>
	</head>
	<body style="margin: 50px;">
		请稍后...
	</body>
</html>