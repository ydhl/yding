<?php
/**
 * 服务窗关注者列表
 * @author ydhlleeboo
 *
 */
class YDing_Channel_Users_Response extends YDingResponse{
	
	/**
	 * 是否有更多的关注者,如果为false则不用再获取,如果为true,则需要重复调用接口增加offset继续获取
	 * @var boolean
	 */
	public $hasMore;

	/**
	 * @var array YDing_Channel_User_Base_Response数组
	 */
	public $users;
	
	public function build($msg){
		parent::build($msg);
		$this->openids = array();
		$this->unionids = array();
		foreach ($this->userList as $user){
			$user["errcode"] = $this->errcode;
			$user["errmsg"] = $this->errmsg;
			$msg = json_encode($user);
			$u= new YDing_Channel_User_Base_Response();
			$u->build($msg);
			$this->users[] = $u;
		}
	}
}
/**
 * 服务窗关注者基本信息
 * @author ydhlleeboo
 *
 */
class YDing_Channel_User_Base_Response extends YDingResponse{
	/**
	 * 在 本服务窗运营服务商 范围内,唯一标识关注者身份的id
	 * @var string
	 */
	public $openid;
	/**
	 * 该用户是否关注了本服务窗,当关注时值为1,当用户取消关注后,值为0且其余字段都没有值
	 * @var unknown
	 */
	public $subscribe;
	/**
	 * 在本 服务窗技术开发商 范围内,唯一标识关注者身份的id
	 * @var unknown
	 */
	public $unionid;
}
/**
 * 服务创关注者详情
 * @author ydhlleeboo
 *
 */
class YDing_Channel_User_Response extends YDing_Channel_User_Base_Response{

	/**
	 * 关注者在钉钉上的昵称
	 * @var string
	 */
	public $nickname;

	/**
	 * 关注者在钉钉上的头像链接
	 * @var string
	 */
	public $avatar;

	/**
	 * 在 本服务窗运营服务商 范围内,唯一标识关注者身份的id
	 * @var string
	 */
	public $openid;
	/**
	 * 该用户是否关注了本服务窗,当关注时值为1,当用户取消关注后,值为0且其余字段都没有值
	 * @var unknown
	 */
	public $subscribe;
	/**
	 * 在本 服务窗技术开发商 范围内,唯一标识关注者身份的id
	 * @var unknown
	 */
	public $unionid;
}
?>