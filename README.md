# yding
yding开发库提供了一种简单的方式来把已有系统和钉钉进行集成。

# 使用方法

1. 配置\_\_confing\_\_.php
2. 注册hook，见文档中hook说明

# 0.1版本功能点

- 钉钉PC企业微应用免登流程
- 钉钉APP企业微应用免登流程
- 发送企业会话消息（工作通知）
- 获取access token，jsapi ticket，请配合ydtimer.yidianhulian.com或者定时器使用
- 获取部门列表，部门详情，用户列表，用户详情


# hook

hook放置于ydinghooks目录中，其中的文件会被自动包含

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