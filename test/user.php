<?php
chdir ( dirname ( __FILE__ ) ); // 把工作目录切换到文件所在目录
include_once dirname ( __FILE__ ) . '/../__config__.php';
?>
<html>
<head>
<meta charset="UTF-8" />
</head>
<body>
	部门列表
	<pre>
	<?php
	var_dump ( yding_get_user_detail( yding_get_access_token () ,"03433826651197") );
	?>	
	</pre>
</body>


</html>
