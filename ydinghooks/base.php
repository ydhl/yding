<?php
YDingHook::add_hook ( YDingHook::GET_ACCESS_TOKEN, function () {
} );

YDingHook::add_hook ( YDingHook::REFRESH_ACCESS_TOKEN, function ($token) {
} );

YDingHook::add_hook ( YDingHook::GET_JS_API_TICKET, function () {
} );

YDingHook::add_hook ( YDingHook::REFRESH_JS_API_TICKET, function ($ticket) {
} );
YDingHook::add_hook ( YDingHook::AUTH_SUCCESS, function ($user) {
	print_r ( $user );
} );
YDingHook::add_hook ( YDingHook::AUTH_FAIL, function ($errmsg) {
	echo $errmsg;
} );
		