<?php
chdir ( dirname ( __FILE__ ) ); // 把工作目录切换到文件所在目录
include_once dirname ( __FILE__ ) . '/../__config__.php';
header("Location: ".yding_sns_qrcode_login_link(YDing_SNS_APPID, YDing_SNS_APP_SECRET));