<?php
/**
 * 查询部门用户请求参数
 * @author ydhlleeboo
 *
 */
class YDing_Department_Get_User_Request extends YDingRequest{
	/**
	 * 代表按照进入部门的时间升序
	 * @var string
	 */
	const ORDER_ENTRY_ASC = "entry_asc";
	/**
	 * 代表按照进入部门的时间降序
	 * @var string
	 */
	const ORDER_ENTRY_DESC = "entry_desc";
	/**
	 * 代表按照部门信息修改时间升序
	 * @var string
	 */
	const ORDER_MODIFIY_ASC = "modify_asc";
	/**
	 * 代表按照部门信息修改时间降序
	 * @var string
	 */
	const ORDER_MODIFY_DESC = "modify_desc";
	/**
	 * 代表用户定义(未定义时按照拼音)排序
	 * @var string
	 */
	const ORDER_CUSTOM = "custom";
	
	/**
	 * 获取的部门id
	 * @var unknown
	 */
	public $department_id;
	/**
	 * 支持分页查询，与size参数同时设置时才生效，此参数代表偏移量
	 * @var unknown
	 */
	public $offset;
	/**
	 * 支持分页查询，与offset参数同时设置时才生效，此参数代表分页大小，最大100
	 * @var unknown
	 */
	public $size;
	/**
	 * 支持分页查询，部门成员的排序规则，默认不传是按自定义排序；entry_asc代表按照进入部门的时间升序，entry_desc代表按照进入部门的时间降序，modify_asc代表按照部门信息修改时间升序，modify_desc代表按照部门信息修改时间降序，custom代表用户定义(未定义时按照拼音)排序
	 * @var unknown
	 */
	public $order;
	/**
	 * 通讯录语言(默认zh_CN另外支持en_US)
	 * @var unknown
	 */
	public $lang = "zh_CN";
	public $access_token;
	
	public function valid(){
		
	}
}
/**
 * 用户永久授权信息
 * @author ydhlleeboo
 *
 */
class YDing_Sns_Persistent_Response extends YDingResponse{
	/**
	 * 用户在当前开放应用内的唯一标识
	 * @var unknown
	 */
	public $openid;
	/**
	 * 用户在当前钉钉开放平台账号范围内的唯一标识，同一个钉钉开放平台账号可以包含多个开放应用，同时也包含ISV的套件应用及企业应用
	 * @var unknown
	 */
	public $unionid;
	/**
	 * 用户给开放应用授权的持久授权码，此码目前无过期时间
	 * @var unknown
	 */
	public $persistent_code;
}
interface YDing_DingDing_Identifiable{
	public function getDingDingId();
}
/**
 * 网站扫码登录返回的用户信息
 * @author ydhlleeboo
 *
 */
class YDing_Sns_User_Response extends YDingResponse implements YDing_DingDing_Identifiable{
	/**
	 * 经过处理的手机号（默认不返回）
	 * @var unknown
	 */
	public $maskedMobile;
	/**
	 * 用户在钉钉上面的昵称
	 * @var unknown
	 */
	public $nick;
	/**
	 * 用户在当前开放应用内的唯一标识
	 * @var unknown
	 */
	public $openid;
	/**
	 * 用户在当前开放应用所属的钉钉开放平台账号内的唯一标识
	 * @var unknown
	 */
	public $unionid;
	/**
	 * 钉钉Id
	 * @var unknown
	 */
	public $dingId;
	/**
	 * 企业数组[
        {
            "corp_name": "阿里巴巴",
            "is_auth": true,
            "is_manager": false,
            "rights_level": 100
        },
        {
            "corp_name": "DingTalk",
            "is_auth": true,
            "is_manager": false,
            "rights_level": 200
        }
    ]
	 * @var unknown
	 */
	public $corp_info;
	
	public function build($msg){
		parent::build($msg);
		$this->maskedMobile = $this->user_info["maskedMobile"];
		$this->nick 		= $this->user_info["nick"];
		$this->openid 		= $this->user_info["openid"];
		$this->unionid 		= $this->user_info["unionid"];
		$this->dingId 		= $this->user_info["dingId"];
	}
	public function getDingDingId(){
		return $this->dingId;
	}
}

/**
 * 免登时返回的基础信息
 * @author ydhlleeboo
 *
 */
class YDing_Base_User_Response extends YDingResponse{
	/**
	 * 	员工在企业内的UserID，注意不是DingDing ID
	 * @var unknown
	 */
	public $userid;
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
class YDing_User_Detail_Response extends YDingResponse implements YDing_DingDing_Identifiable{
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
	
	public function getDingDingId(){
		return $this->dingId;
	}
}

/**
 * 钉钉后台应用免登返回信息
 * @author ydhlleeboo
 *
 */
class YDing_SSO_User_Response extends YDingResponse{
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
	
	public function build($msg){
		parent::build($msg);
		
		$this->corp_name = $this->corp_info["corp_name"];
		$this->corpid    = $this->corp_info["corpid"];
		$this->avatar    = $this->user_info["avatar"];
		$this->email     = $this->user_info["email"];
		$this->name      = $this->user_info["name"];
		$this->userid    = $this->user_info["userid"];
	}
}
/**
 * 创建、更新部门信息
 * @author ydhlleeboo
 *
 */
class YDing_Department_Save_Request extends YDingRequest{
    /**
     * 部门id，创建时没有
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
     * 在父部门中的次序值。order值小的排序靠前
     */
    public $order;
    /**
     * 是否同步创建一个关联此部门的企业群, true表示是, false表示不是
     */
    public $createDeptGroup;
    
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
    
    
    public  function valid(){
        
    }
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

/**
 * 创建、更新成员属性
 * @author ydhlleeboo
 *
 */
class YDing_User_Save_Request extends YDingRequest{
    /**
     * 员工唯一标识ID（不可修改），企业内必须唯一。长度为1~64个字符，如果不传，服务器将自动生成一个userid
     * @var unknown
     */
    public $userid;
    /**
     * 成员名称。长度为1~64个字符
     * @var unknown
     */
    public $name;
    /**
     * 在对应的部门中的排序,  key是部门的Id, value是人员在这个部门的排序值
     * @var array
     */
    public $orderInDepts;
    /**
     * 数组类型，数组里面值为整型，成员所属部门id列表
     * @var array
     */
    public $department;
    /**
     * 职位信息。长度为0~64个字符
     * @var unknown
     */
    public $position;
    /**
     * 手机号码。企业内必须唯一
     * @var unknown
     */
    public $mobile;
    /**
     * 分机号，长度为0~50个字符
     * @var unknown
     */
    public $tel;
    /**
     * 办公地点，长度为0~50个字符
     * @var unknown
     */
    public $workPlace;
    /**
     * 备注，长度为0~1000个字符
     * @var unknown
     */
    public $remark;
    /**
     * 邮箱。长度为0~64个字符。企业内必须唯一
     * @var unknown
     */
    public $email;
    /**
     * 员工工号。对应显示到OA后台和客户端个人资料的工号栏目。长度为0~64个字符
     * @var unknown
     */
    public $jobnumber;
    /**
     * 是否号码隐藏, true表示隐藏, false表示不隐藏。隐藏手机号后，手机号在个人资料页隐藏，但仍可对其发DING、发起钉钉免费商务电话
     * @var unknown
     */
    public $isHide;
    /**
     * 是否高管模式，true表示是，false表示不是。开启后，手机号码对所有员工隐藏。普通员工无法对其发DING、发起钉钉免费商务电话。高管之间不受影响。
     * @var unknown
     */
    public $isSenior;
    /**
     * 扩展属性，可以设置多种属性(但手机上最多只能显示10个扩展属性，具体显示哪些属性，请到OA管理后台->设置->通讯录信息设置和OA管理后台->设置->手机端显示信息设置)
     * "爱好"=>"旅游","年龄"=>"24"
     * @var array
     */
    public $extattr;
    
    public  function valid(){
        
    }
}