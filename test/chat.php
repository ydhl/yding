<?php
chdir ( dirname ( __FILE__ ) ); // 把工作目录切换到文件所在目录
include_once dirname ( __FILE__ ) . '/../__config__.php';
?>
<html>
<head>
<meta charset="UTF-8" />
</head>
<body>
	发送测试文本
	<pre>
	<?php
	$request = new YDing_Crop_Sendmsg_Request();
	$request->agentid = YDing_AGENTID;
	$request->toparty = array("19350308");
// 	$msg = new YDing_Sendmsg_Text_Request();
// 	$msg->content = "测试文本消息";
	$msg = new YDing_Sendmsg_OA_Request();
	$msg->body_author = "leeboo";
	$msg->body_content = "test body content";
	$msg->body_title = "test body title";
	$msg->head_bgcolor = "50444444";
	$msg->head_text = "test head";
	$msg->body_rich_num = '10';
	$msg->body_rich_unit = "项";
	$msg->message_url = "http://oa.yidianhulian.com";
	$msg->pc_message_url = "http://oa.yidianhulian.com";
	
	$request->msg = $msg;
	try{
		var_dump ( yding_crop_sendmsg( yding_get_access_token () , $request) );
	}catch (\Exception $e){
		print_r($e);
	}
	?>	
	</pre>
</body>


</html>
