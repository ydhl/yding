<?php

YDingHook::add_hook ( YDingHook::AUTH_SUCCESS, function ($user) {
	print_r ( $user );
	echo "<a href='/test/js.php'>js 测试</a>";
} );
YDingHook::add_hook ( YDingHook::AUTH_FAIL, function ($errmsg) {
	echo "autu_fail:".$errmsg;
} );

YDingHook::add_hook ( YDingHook::EXCEPTION, function (Exception $e) {
	echo "exception:".$e->getMessage();
} );