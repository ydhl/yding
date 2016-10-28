<?php
chdir ( dirname ( __FILE__ ) ); // 把工作目录切换到文件所在目录
include_once dirname ( __FILE__ ) . '/../__config__.php';
?>
<html>
<head>
<meta charset="UTF-8" />
</head>
<body>
	企业自建(也就是企业自己开发的)服务窗应用时获取服务窗ChannelToken.
	<pre>
	<?php
	try{
		$accessToken = yding_get_channel_token( );
		var_dump ( $accessToken );
	}catch (\Exception $e){
		print_r($e);
	}
	?>	
	</pre>

    获取服务窗关注者列表(外部联系人列表).
    <pre>
    <?php
    try{
    	$obj = yding_get_channel_users($accessToken);
        var_dump ( $obj );
    }catch (\Exception $e){
        print_r($e);
    }
    ?>  
    </pre>
    
    获取服务窗关注者详情.
    <pre>
    <?php
    try{
        var_dump ( yding_get_channel_user($accessToken, $obj->users[0]->openid) );
    }catch (\Exception $e){
        print_r($e);
    }
    ?>  
    </pre>
</body>


</html>
