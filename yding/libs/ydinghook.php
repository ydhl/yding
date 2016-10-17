<?php

/**
 * hook定义
 *
 * 该文件为系统提供hook机制
 * @author leeboo
 * @since 2009-9-1
 */

final class YDingHook {
	/**
	 * 出现异常的hook，参数是ydexception实例
	 * @var string
	 */
	const EXCEPTION 	 		= "exception";
	/**
	 * 刷新access token，参数是得到的access token；请宿主系统把该值存在本地数据库中；
	 * 以便其他地方直接使用，其他地方将通过GET_ACCESS_TOKEN直接取本地存储的值
	 * @var string
	 */
    const REFRESH_ACCESS_TOKEN 	= "access_token";
    
    /**
     * 从宿主系统中获取access token；无hook 参数；
     * 通常情况下，宿主系统应该吧REFRESH_ACCESS_TOKEN得到的access token存下来，并通过access_token.php
     * 定时刷新（access token有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_get_access_token()再次请求
     * @var string
     */
    const GET_ACCESS_TOKEN = "get_access_token";
    
    /**
     * 刷新获取微应用后台管理免登SsoToken，参数是得到的sso token
     * @var string
     */
    const REFRESH_SSO_TOKEN 	= "sso_token";
    
    /**
     * 刷新jsapi ticket，参数是得到的ticket。请宿主系统把该值存在本地数据库中；
	 * 以便其他地方直接使用，其他地方将通过GET_JS_API_TICKET直接取本地存储的值
     * @var string
     */
    const REFRESH_JS_API_TICKET 	= "jsapi_ticket";
    /**
     * 从宿主系统中获取jsapi_ticket；无hook 参数；
     * 通常情况下，宿主系统应该吧REFRESH_JS_API_TICKET得到的ticket存下来，并通过jsapi_ticket.php
     * 定时刷新（有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_get_jsapi_ticket()再次请求
     * @var string
     */
    const GET_JS_API_TICKET 	= "get_jsapi_ticket";
    
    /**
     * 免登成功回调，参数是YDing_Base_User_Response
     * @var string
     */
    const AUTH_SUCCESS 	= "auth_success";
    
    /**
     * 免登失败回调，参数是错误消息字符串
     * @var string
     */
    const AUTH_FAIL 	= "auth_fail";
    
    private static $listeners = array ();
    /**
     * 增加hook
     */
    public static function add_hook($event, $func_name, $object = null) {
        self::$listeners [$event] [] = array (
                "function" => $func_name,
                "object" => $object 
        );
    }
    
    public static function do_hook($filter_name, $data=array()) {
        if (! self::has_hook ( $filter_name ))
            return $data;
        foreach ( self::$listeners [$filter_name] as $listeners ) {
            if (is_object ( $listeners ['object'] )) {
                $data = call_user_func ( array($listeners ['object'], $listeners ['function']), $data);
            } else {
                $data = call_user_func ( $listeners ['function'], $data );
            }
        }
        return $data;
    }
    
    public static function has_hook($filter_name) {
        return @self::$listeners [$filter_name];
    }
    
    public static function allhooks(){
        return self::$listeners;
    }
    
    public static function include_files($dir){
        if( ! file_exists($dir) )return;
        foreach(glob($dir."/*") as $file){
            if (is_dir($file)) {
                self::include_files($file);
            }else if(is_file($file)){
                require_once $file;
            }
        }
    }
}

?>
