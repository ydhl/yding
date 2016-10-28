<?php
/**
 * 该文件是对所有需要刷新的token，ticket数据进行统一调用，ydtimer.yidianhulian.com或者自己的定时器可以只触发调用该文件
 * @author leeboo
 */

include 'access_token.php';
include 'channel_isv_token.php';
include 'channel_jsapi_ticket.php';
include 'channel_token.php';
include 'jsapi_ticket.php';
include 'sso_token.php';