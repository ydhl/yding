<?php
include_once 'auth.inc.php';
?>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>登录中...</title>
		<?php yding_jsapi_init();?>
		<script type="text/javascript">
			
		dd.config({
		    agentId: "<?php echo $_GET["agentid"]?>",
		    corpId:  "<?php echo YDing_CORPID?>",
		    timeStamp: "<?php echo $timeStamp?>",
		    nonceStr: "<?php echo $nonceStr?>",
		    signature: "<?php echo $signature?>",
            type: <?php echo intval($jsapi_type)?>,
		    jsApiList: [
		        'runtime.info',
		        'device.notification.prompt',
		        'biz.chat.pickConversation',
		        'device.notification.confirm',
		        'device.notification.alert',
		        'device.notification.prompt',
		        'biz.chat.open',
		        'biz.util.open',
		        'biz.user.get',
		        'biz.contact.choose',
		        'biz.telephone.call',
		        'biz.ding.post']
		});
		dd.userid=0;
		dd.ready(function() {
		    
		    dd.runtime.info({
		        onSuccess: function(info) {
		        	console.log('runtime info: ' + JSON.stringify(info));
		        },
		        onFail: function(err) {
		        	console.log('fail: ' + JSON.stringify(err));
		        }
		    });

		    dd.runtime.permission.requestAuthCode({
		        corpId: "<?php echo YDing_CORPID?>", //企业id
		        onSuccess: function (info) {
		        	//console.log('authcode: ' + info.code);
		        	window.location.href = "<?php echo $url. (strpos($url, "?")!==false ? "&" : "?")?>code="+info.code;
		        },
		        onFail: function (err) {
		        	//console.log('requestAuthCode fail: ' + JSON.stringify(err));
		        	window.location.href = "<?php echo $url. (strpos($url, "?")!==false ? "&" : "?");?>error="+JSON.stringify(err);
		        }
		    }); 
		});

		dd.error(function(err) {
			//console.log('dd error: ' + JSON.stringify(err));
			window.location.href = "<?php echo $url. (strpos($url, "?")!==false ? "&" : "?")?>error="+JSON.stringify(err);
		});
		</script>
	</head>
	<body style="margin: 50px;">
		请稍后
	</body>
</html>