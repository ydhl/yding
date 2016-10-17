<?php
class YDing_Base_User_Response extends YDingResponse{
	/**
	 * 非管理员用户
	 * @var integer
	 */
	const SYS_LEVEL_USER = 0;
	/**
	 * 超级管理员（主管理员）
	 * @var integer
	 */
	const SYS_LEVEL_ROOT = 1;
	/**
	 * 普通管理员（子管理员）
	 * @var integer
	 */
	const SYS_LEVEL_ADMIN = 2;
	/**
	 * 老板用户
	 * @var integer
	 */
	const SYS_LEVEL_BOSS = 100;
	
	/**
	 * 	员工在企业内的UserID
	 * @var unknown
	 */
	public $userid;
	
	/**
	 * 手机设备号,由钉钉在安装时随机产生
	 * @var unknown
	 */
	public $deviceId;
	
	
	/**
	 * 是否是管理员
	 * @var unknown
	 */
	public $is_sys;
	
	/**
	 * 级别，0：非管理员 1：超级管理员（主管理员） 2：普通管理员（子管理员） 100：老板
	 * @var unknown
	 */
	public $sys_level;
}

/**
 * 用户详情
 * @author ydhlleeboo
 *
 */
class YDing_User_Response extends YDing_Base_User_Response{
	/**
	 * 成员名称
	 * @var unknown
	 */
	public $name;
	/**
	 * 分机号（ISV不可见）
	 * @var unknown
	 */
	public $tel;
	/**
	 * 办公地点（ISV不可见）
	 * @var unknown
	 */
	public $workPlace;
	/**
	 * 备注（ISV不可见）
	 * @var unknown
	 */
	public $remark;
	/**
	 * 手机号码（ISV不可见）
	 * @var unknown
	 */
	public $mobile;
	/**
	 * 员工的电子邮箱（ISV不可见）
	 * @var unknown
	 */
	public $email;
	/**
	 * 员工的企业邮箱（ISV不可见）
	 * @var unknown
	 */
	public $orgEmail;
	
	/**
	 * 是否已经激活, true表示已激活, false表示未激活
	 * @var unknown
	 */
	public $active;
	/**
	 * 在对应的部门中的排序, Map结构的json字符串, key是部门的Id, value是人员在这个部门的排序值
	 * @var array
	 */
	public $orderInDepts;
	/**
	 * 是否为企业的管理员, true表示是, false表示不是
	 * @var unknown
	 */
	public $isAdmin;
	/**
	 * 是否为企业的老板, true表示是, false表示不是
	 * @var unknown
	 */
	public $isBoss;
	/**
	 * 钉钉Id
	 * @var unknown
	 */
	public $dingId;
	/**
	 * 在对应的部门中是否为主管, Map结构的json字符串, key是部门的Id, value是人员在这个部门中是否为主管, true表示是, false表示不是
	 * @var unknown
	 */
	public $isLeaderInDepts;
	/**
	 * 是否号码隐藏, true表示隐藏, false表示不隐藏
	 * @var unknown
	 */
	public $isHide;
	/**
	 * 成员所属部门id列表
	 * @var unknown
	 */
	public $department;
	/**
	 * 职位信息
	 * @var unknown
	 */
	public $position;
	/**
	 * 头像url
	 * @var unknown
	 */
	public $avatar;
	/**
	 * 员工工号
	 * @var unknown
	 */
	public $jobnumber;
	/**
	 * 扩展属性，可以设置多种属性(但手机上最多只能显示10个扩展属性，具体显示哪些属性，请到OA管理后台->设置->通讯录信息设置和OA管理后台->设置->手机端显示信息设置)性
	 * @var array
	 */
	public $extattr;
	
	public function build($msg){
		parent::build($msg);
// 		$this->orderInDepts = json_decode($this->orderInDepts, true);
// 		$this->isLeaderInDepts = json_encode($this->isLeaderInDepts, true);
		$this->extattr = json_encode($this->extattr,true);
	}
}

class YDing_ISV_Admin_Response extends YDingResponse{
	/**
	 * 公司名字
	 * @var unknown
	 */
	public $corp_name;
	/**
	 * 公司corpid
	 * @var unknown
	 */
	public $corpid;
	/**
	 * 是否是管理员（在这里是true）
	 * @var unknown
	 */
	public $is_sys;
	/**
	 * 头像地址
	 * @var unknown
	 */
	public $avatar;
	/**
	 * email地址",
	 * @var unknown
	 */
	public $email;
	/**
	 * 用户名字,
	 * @var unknown
	 */
	public $name;
	/**
	 * 员工在企业内的UserID
	 * @var unknown
	 */
	public $userid;
}

/**
 * 基础部门信息
 * @author ydhlleeboo
 *
 */
class YDing_Department_Base extends YDingResponse{
	/**
	 * 部门id
	 */
	public $id;
	/**
	 * 部门名称
	 */
	public $name;
	/**
	 * 父部门id，根部门为1
	 */
	public $parentid;
	/**
	 * 是否同步创建一个关联此部门的企业群, true表示是, false表示不是
	 */
	public $createDeptGroup;
	/**
	 * 当群已经创建后，是否有新人加入部门会自动加入该群, true表示是, false表示不是
	 */
	public $autoAddUser;
}

/**
 * 部门详情
 * @author ydhlleeboo
 *
 */
class YDing_Department_Info extends YDing_Department_Base{
	/**
	 * 是否隐藏部门, true表示隐藏, false表示显示
	 */
	public $deptHiding;
	/**
	 * 可以查看指定隐藏部门的其他部门列表，如果部门隐藏，则此值生效，取值为其他的部门id组成的的字符串，使用|符号进行分割
	 */
	public $deptPerimits;
	/**
	 * 可以查看指定隐藏部门的其他人员列表，如果部门隐藏，则此值生效，取值为其他的人员userid组成的的字符串，使用|符号进行分割
	 */
	public $userPerimits;
	/**
	 * 是否本部门的员工仅可见员工自己, 为true时，本部门员工默认只能看到员工自己
	 */
	public $outerDept;
	/**
	 * 本部门的员工仅可见员工自己为true时，可以配置额外可见部门，值为部门id组成的的字符串，使用|符号进行分割
	 */
	public $outerPermitDepts;
	/**
	 * 本部门的员工仅可见员工自己为true时，可以配置额外可见人员，值为userid组成的的字符串，使用| 符号进行分割
	 */
	public $outerPermitUsers;
	/**
	 * 企业群群主
	 */
	public $orgDeptOwner;
	/**
	 * 部门的主管列表,取值为由主管的userid组成的字符串，不同的userid使用|符号进行分割
	 */
	public $deptManagerUseridList;
}