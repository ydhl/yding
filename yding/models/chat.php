<?php
class YDing_Chat_Create_Request extends YDingRequest{
	/**
	 * 群名称。长度限制为1~20个字符
	 * @var unknown
	 */
	public $name;
	/**
	 * 群主userId，员工唯一标识ID；必须为该会话useridlist的成员之一
	 * @var unknown
	 */
	public $owner;
	/**
	 * 群成员列表，每次最多操作40人，群人数上限为1000
	 * @var array
	 */
	public $useridlist;
	public function valid(){
		
	}
}


abstract class YDing_Sendmsg_Base extends YDingRequest{
}

class YDing_Sendmsg_Text_Request extends YDing_Sendmsg_Base{

	/**
	 * 消息内容
	 * @var unknown
	 */
	public $content;
	public function valid(){
	
	}
	protected function formatArgs(){
		$args = parent::formatArgs();
		unset($args["content"]);
		$args["msgtype"] = "text";
		$args["text"]["content"] = $this->content;
		return $args;
	}
}

class YDing_Sendmsg_Image_Request extends YDing_Sendmsg_Base{
	/**
	 * 图片媒体文件id，可以调用上传媒体文件接口获取。建议宽600像素 x 400像素，宽高比3：2
	 * @var unknown
	 */
	public $media_id;
	public function valid(){

	}
	protected function formatArgs(){
		$args = parent::formatArgs();
		unset($args["media_id"]);
		$args["msgtype"] = "image";
		$args["image"]["media_id"] = $this->media_id;
		return $args;
	}
}

class YDing_Sendmsg_Voice_Request extends YDing_Sendmsg_Base{
	/**
	 * 语音媒体文件id，可以调用上传媒体文件接口获取。2MB，播放长度不超过60s，AMR格式
	 * @var unknown
	 */
	public $media_id;
	/**
	 * 正整数，小于60，表示音频时长
	 * @var unknown
	 */
	public $duration;
	public function valid(){

	}
	protected function formatArgs(){
		$args = parent::formatArgs();
		unset($args["media_id"]);
		unset($args["duration"]);
		$args["msgtype"] = "voice";
		$args["voice"]["media_id"] = $this->media_id;
		$args["voice"]["duration"] = $this->duration;
		return $args;
	}
}

class YDing_Sendmsg_File_Request extends YDing_Sendmsg_Base{
	/**
	 * 媒体文件id，可以调用上传媒体文件接口获取。10MB
	 * @var unknown
	 */
	public $media_id;
	
	public function valid(){

	}
	protected function formatArgs(){
		$args = parent::formatArgs();
		unset($args["media_id"]);
		$args["msgtype"] = "file";
		$args["file"]["media_id"] = $this->media_id;
		return $args;
	}
}

class YDing_Sendmsg_Link_Request extends YDing_Sendmsg_Base{
	/**
	 * 消息标题
	 * @var unknown
	 */
	public $title;
	/**
	 * 消息描述
	 * @var unknown
	 */
	public $text;
	/**
	 * 图片媒体文件id，可以调用上传媒体文件接口获取
	 * @var unknown
	 */
	public $pic_url;
	/**
	 * 消息点击链接地址
	 * @var unknown
	 */
	public $message_url;

	public function valid(){

	}
	protected function formatArgs(){
		$args = parent::formatArgs();
		unset($args["title"]);
		unset($args["text"]);
		unset($args["pic_url"]);
		unset($args["message_url"]);
		$args["msgtype"] = "link";
		$args["link"]["title"] 		= $this->title;
		$args["link"]["text"] 		= $this->text;
		$args["link"]["pic_url"] 	= $this->pic_url;
		$args["link"]["message_url"]= $this->message_url;
		return $args;
	}
}

class YDing_Sendmsg_OA_Request extends YDing_Sendmsg_Base{
	/**
	 * 客户端点击消息时跳转到的H5地址
	 * @var unknown
	 */
	public $message_url;
	/**
	 * PC端点击消息时跳转到的URL地址
	 * @var unknown
	 */
	public $pc_message_url;
	/**
	 * 消息头部的背景颜色。长度限制为8个英文字符，其中前2为表示透明度，后6位表示颜色值。不要添加0x
	 * @var unknown
	 */
	public $head_bgcolor;
	/**
	 * 消息的头部标题（仅适用于发送普通场景）
	 * @var unknown
	 */
	public $head_text;
	/**
	 * 消息体的标题
	 * @var unknown
	 */
	public $body_title;
	/**
	 * 是消息头关键字,与key对应
	 * @var unknown
	 */
	public $body_form_keys;
	/**
	 * 消息体的关键字对应的值,与key对应
	 * @var unknown
	 */
	public $body_form_values;
	/**
	 * 单行富文本信息的数目
	 * @var unknown
	 */
	public $body_rich_num;
	/**
	 * 单行富文本信息的单位
	 * @var unknown
	 */
	public $body_rich_unit;
	/**
	 * 消息体的内容，最多显示3行
	 * @var unknown
	 */
	public $body_content;
	/**
	 * 消息体中的图片media_id
	 * @var unknown
	 */
	public $body_image;
	/**
	 * 自定义的附件数目。此数字仅供显示，钉钉不作验证
	 * @var unknown
	 */
	public $body_file_count;
	/**
	 * 自定义的作者名字
	 * @var unknown
	 */
	public $body_author;

	public function valid(){

	}
	protected function formatArgs(){
		$args = parent::formatArgs();
		unset($args["message_url"]);
		unset($args["pc_message_url"]);
		unset($args["head_bgcolor"]);
		unset($args["head_text"]);
		unset($args["body_title"]);
		unset($args["body_form_keys"]);
		unset($args["body_form_values"]);
		unset($args["body_rich_num"]);
		unset($args["body_rich_unit"]);
		unset($args["body_content"]);
		unset($args["body_image"]);
		unset($args["body_file_count"]);
		unset($args["body_author"]);
		$args["msgtype"] = "oa";
		$args["oa"]["message_url"] = $this->message_url;
		$args["oa"]["pc_message_url"] = $this->pc_message_url;
		$args["oa"]["head"]["bgcolor"] = $this->head_bgcolor;
		$args["oa"]["head"]["text"] = $this->head_text;
		$args["oa"]["body"]["title"] = $this->body_title;
		$args["oa"]["body"]["content"] = $this->body_content;
		$args["oa"]["body"]["image"] = $this->body_image;
		$args["oa"]["body"]["file_count"] = $this->body_file_count;
		$args["oa"]["body"]["author"] = $this->body_author;
		if ($this->body_rich_num){
			$args["oa"]["body"]["rich"]["num"] = $this->body_rich_num;
			$args["oa"]["body"]["rich"]["unit"] = $this->body_rich_unit;
		}
		foreach ($this->body_form_keys as $index => $key){
			$args["oa"]["body"]["form"][] = array(
					"key" => $key, 
					"value"=>$this->body_form_values[$index]
			);
		}
		
		return $args;
	}
}

class YDing_Chat_Create_Response extends YDingResponse{
	/**
	 * 	群会话的id
	 * @var unknown
	 */
	public $chatid;
}

/**
 * 发送群会话消息
 * @author ydhlleeboo
 *
 */
class YDing_Chat_Sendmsg_Request extends YDingRequest{
	/**
	 * 群会话的id
	 * @var unknown
	 */
	public $chatid;
	/**
	 * 发送者的userid
	 * @var unknown
	 */
	public $sender;

	/**
	 * 消息体
	 * @var YDing_Sendmsg_Base
	 */
	public $msg;
	public function valid(){
	
	}
	
	protected function formatArgs(){
		$args = parent::formatArgs();
		unset($args["msg"]);
		array_merge($args, $this->msg->toArray());
		return $args;
	}
}
/**
 * 服务窗消息
 * @author ydhlleeboo
 *
 */
class YDing_Channel_Sendmsg_Request extends YDingRequest{
	/**
	 * 由接收人的openid组成的字符串
	 * @var array
	 */
	public $touser;
	/**
	 * 服务窗应用的代理id
	 * @var string
	 */
	public $channelAgentId;
	
	/**
	 * 消息题
	 * @var YDing_Sendmsg_Base
	 */
	public $msg;
	
	public function valid(){
	
	}
	public function sortArg(){
		$args = $this->formatArgs();
		return $args;
	}
	protected function formatArgs(){
		$args = parent::formatArgs();
		unset($args["msg"]);
	
		if ($this->touser)  $args["touser"]  = join("|", (array)$this->touser);
	
		$args = array_merge($args, $this->msg->toArray());
	
		//消息头必须按照消息头和消息体的格式
		//https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.aTVcCa&treeId=255&articleId=105566&docType=1
		//touser toparty agentid msgtype
		return $args;
	}
}
/**
 * 服务窗消息响应
 * @author ydhlleeboo
 *
 */
class YDing_Channel_Sendmsg_Response extends YDingResponse{
	/**
	 * 	无效的userid
	 * @var array
	 */
	public $invaliduser;
	/**
	 * 标发送消息的任务id
	 */
	public $taskid;

	public function build($msg){
		parent::build($msg);
		$this->invaliduser = explode("|", $this->invaliduser);
	}
}

/**
 * 发送企业消息请求
 * @author ydhlleeboo
 *
 */
class YDing_Crop_Sendmsg_Request extends YDingRequest{
	/**
	 * 员工id列表（消息接收者）
	 * @var array
	 */
	public $touser;
	/**
	 * 部门id列表。touser或者toparty 二者有一个必填
	 * @var array
	 */
	public $toparty;
	/**
	 * 企业应用id，这个值代表以哪个应用的名义发送消息
	 * @var unknown
	 */
	public $agentid;
	
	/**
	 * 消息题
	 * @var YDing_Sendmsg_Base
	 */
	public $msg;
	
	public function valid(){
		
	}
	public function sortArg(){
		$args = $this->formatArgs();
		return $args;
	}
	protected function formatArgs(){
		$args = parent::formatArgs();
		unset($args["msg"]);
		
		if ($this->touser)  $args["touser"]  = join("|", (array)$this->touser);
		if ($this->toparty) $args["toparty"] = join("|", (array)$this->toparty);
		
		$args = array_merge($args, $this->msg->toArray());
		
		//消息头必须按照消息头和消息体的格式
		//https://open-doc.dingtalk.com/docs/doc.htm?spm=a219a.7629140.0.0.LkFOWs&treeId=172&articleId=104973&docType=1
		//touser toparty agentid msgtype
		return $args;
	}
}

/**
 * 发送企业消息响应
 * @author ydhlleeboo
 *
 */
class YDing_Crop_Sendmsg_Response extends YDingResponse{
	/**
	 * 	无效的userid
	 * @var array
	 */
	public $invaliduser;
	/**
	 * 无效的部门id
	 * @var array
	 */
	public $invalidparty;
	/**
	 * 标识企业消息的id，字符串，最长128个字符
	 */
	public $messageId;
	
	public function build($msg){
		parent::build($msg);
		$this->invalidparty = explode("|", $this->invalidparty);
		$this->invaliduser = explode("|", $this->invaliduser);
	}
}