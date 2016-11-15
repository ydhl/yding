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
	 * 刷新access token，参数是得到的array(corpid, access token)；请宿主系统把该值存在本地数据库中；
	 * 以便其他地方直接使用，其他地方将通过GET_ACCESS_TOKEN直接取本地存储的值
	 * @var string
	 */
    const REFRESH_ACCESS_TOKEN 	= "access_token";

    /**
     * 从宿主系统中获取access token；hook 参数 corpid；
     * 通常情况下，宿主系统应该吧REFRESH_ACCESS_TOKEN得到的access token存下来，并通过refresh_token.php
     * 定时刷新（access token有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_get_access_token()再次请求
     * @var string
     */
    const GET_ACCESS_TOKEN = "get_access_token";
    /**
     * 刷新sns 网站的(不是微应用)access token，参数是得到的array(appid, access token)；请宿主系统把该值存在本地数据库中；
     * 以便其他地方直接使用，其他地方将通过GET_SNS_ACCESS_TOKEN直接取本地存储的值
     * @var string
     */
    const REFRESH_SNS_ACCESS_TOKEN 	= "sns_access_token";

    /**
     * 从宿主系统中获取网站(不是微应用)的access token；hook 参数 appid；
     * 通常情况下，宿主系统应该吧REFRESH_SNS_ACCESS_TOKEN得到的access token存下来，并通过refresh_token.php
     * 定时刷新（access token有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_sns_get_access_token()再次请求
     * @var string
     */
    const GET_SNS_ACCESS_TOKEN = "get_sns_access_token";
    
    /**
     * 从宿主系统中获取ISV的微应用的suite access token；hook 参数 corpid；
     * 通常情况下，宿主系统应该吧REFRESH_SUITE_ACCESS_TOKEN得到的access token存下来，并通过refresh_token.php
     * 定时刷新（access token有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_get_suite_access_token()再次请求
     * @var string
     */
    const GET_SUITE_ACCESS_TOKEN = "get_suite_access_token";
    /**
     * 刷新ISV微应用的suite access token，参数是得到的(corpid, access token)；请宿主系统把该值存在本地数据库中；
     * 以便其他地方直接使用，其他地方将通过GET_SUITE_ACCESS_TOKEN直接取本地存储的值
     * @var string
     */
    const REFRESH_SUITE_ACCESS_TOKEN = "refresh_suite_access_token";
    /**
     * 刷新企业自建服务窗应用的channel token，参数是得到的(corpid, channel token)；请宿主系统把该值存在本地数据库中；
     * 以便其他地方直接使用，其他地方将通过GET_CHANNEL_TOKEN直接取本地存储的值
     * @var string
     */
    const REFRESH_CHANNEL_TOKEN = "refresh_channel_token";
    /**
     * 从宿主系统中获取企业自建服务窗应用的channel token；hook 参数:corpid
     * 通常情况下，宿主系统应该吧REFRESH_CHANNEL_TOKEN得到的channel token存下来，并通过refresh_token.php
     * 定时刷新（access token有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_get_channel_token()再次请求
     * @var string
     */
    const GET_CHANNEL_TOKEN = "get_channel_token";
    
    
    /**
     * 刷新ISV服务窗应用的channel token，参数是得到的(corpid, channel token)；请宿主系统把该值存在本地数据库中；
     * 以便其他地方直接使用，其他地方将通过GET_CHANNEL_ISV_TOKEN直接取本地存储的值
     * @var string
     */
    const REFRESH_CHANNEL_ISV_TOKEN = "refresh_channel_isv_token";
    /**
     * 从宿主系统中获取ISV服务窗应用的channel token；hook 参数 corpid；
     * 通常情况下，宿主系统应该吧REFRESH_CHANNEL_ISV_TOKEN得到的channel token存下来，并通过refresh_token.php
     * 定时刷新（access token有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_get_channel_isv_token()再次请求
     * @var string
     */
    const GET_CHANNEL_ISV_TOKEN = "get_channel_isv_token";
    /**
     * 刷新isv服务窗的jsapi ticket，参数是得到的(corpid, ticket)。请宿主系统把该值存在本地数据库中；
     * 以便其他地方直接使用，其他地方将通过GET_CHANNEL_JS_API_TICKET直接取本地存储的值
     * @var string
     */
    const REFRESH_CHANNEL_JS_API_TICKET 	= "refresh_channel_js_api_ticket";
    /**
     * 从宿主系统中获取isv企业服务窗的jsapi_ticket；hook 参数 corpid；
     * 通常情况下，宿主系统应该吧REFRESH_CHANNEL_JS_API_TICKET得到的ticket存下来，并通过refresh_token.php
     * 定时刷新（有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_get_channel_jsapi_ticket()再次请求
     * @var string
     */
    const GET_CHANNEL_JS_API_TICKET 	= "get_channel_js_api_ticket";
    /**
     * 刷新jsapi ticket，参数是得到的(corpid, ticket)。请宿主系统把该值存在本地数据库中；
	 * 以便其他地方直接使用，其他地方将通过GET_JS_API_TICKET直接取本地存储的值
     * @var string
     */
    const REFRESH_JS_API_TICKET 	= "jsapi_ticket";
    /**
     * 从宿主系统中获取jsapi_ticket；hook 参数corpid；
     * 通常情况下，宿主系统应该吧REFRESH_JS_API_TICKET得到的ticket存下来，并通过refresh_token.php
     * 定时刷新（有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_get_jsapi_ticket()再次请求
     * @var string
     */
    const GET_JS_API_TICKET 	= "get_jsapi_ticket";

    /**
     * 刷新获取微应用后台管理免登SsoToken，参数是得到的array(corpid, sso token);
     * 请宿主系统把该值存在本地数据库中；
	 * 以便其他地方直接使用，其他地方将通过GET_JS_API_TICKET直接取本地存储的值
	 * ISV开发的微应用后台免登中的SsoToken，使用ISV自己的corpid和ssosecret来换取，不是使用用户企业的
     * @var string
     */
    const REFRESH_SSO_TOKEN 	= "sso_token";
    
    /**
     * 获取微应用后台管理免登SsoToken，参数是得到的array(corpid)， 返回token
     * 通常情况下，宿主系统应该吧REFRESH_SSO_TOKEN得到的sso token存下来，并通过refresh_token.php
     * 定时刷新（有效期为7200）；然后该hook是直接取得本地存的值；
     * 如果该hook无内容返回，可通过yding_get_sso_token()再次请求
     * 
     * ISV开发的微应用后台免登中的SsoToken，使用ISV自己的corpid和ssosecret来换取，不是使用用户企业的
     * @var string
     */
    const GET_SSO_TOKEN 	= "sso_token";
    
    /**
     * 刷新获取ISV提供的微应用后台管理免登SsoToken，参数是得到的array(corpid, sso token)
     * @var string
     */
    const REFRESH_ISV_SSO_TOKEN 	= "isv_sso_token";
    
    /**
     * 免登成功回调，参数是YDing_User_Identifiable
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
    /**
     * 如果没有hook注册，则返回null，如果有hook注册，则返回hook处理后的data，注意每个hook的处理将会进入下一个hook中
     * 
     * @param unknown $filter_name
     * @param array $data
     * @return NULL|mixed
     */
    public static function do_hook($filter_name, $data=array()) {
        if (! self::has_hook ( $filter_name ))
            return null;
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
