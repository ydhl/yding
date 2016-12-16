<?php
include_once 'auth.inc.php';
?>
<html>
	<head>
		<meta charset="UTF-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>登录中...</title>
		<?php yding_pc_jsapi_init();?>
		<script type="text/javascript">
		DingTalkPC.config({
			agentId: <?php echo $_GET["agentid"]?>,
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
		        	window.location.href = "<?php echo $url. (strpos($url, "?")!==false ? "&" : "?")?>code="+info.code;
		        },
		        onFail: function (err) {
		        	//console.log('requestAuthCode fail: ' + JSON.stringify(err));
		        	window.location.href = "<?php echo $url. (strpos($url, "?")!==false ? "&" : "?")?>error="+JSON.stringify(err);
		        }
		    });
		});
		DingTalkPC.error(function(err) {
			//console.log('dd error: ' + JSON.stringify(err));
			window.location.href = "<?php echo $url. (strpos($url, "?")!==false ? "&" : "?")?>error="+JSON.stringify(err);
		});
		</script>
	</head>
	<body style="margin: 50px;">
        <span  style="font-size:90px;font-weight: 100;">:)</span>
		请稍后...
	</body>
</html>