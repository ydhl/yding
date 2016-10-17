<?php
function yding_json_encode($args){
	return urldecode(json_encode(yding_url_encode($args)));
}

function yding_url_encode($array){
	$temp = array();
	foreach($array as $key=>$value){
		if(is_array($value)){
			$temp[$key] = yding_url_encode($value);
		}else if(is_numeric($value) || is_bool($value)){
			$temp[$key] = $value;
		}else{
			$temp[$key] = str_replace("%22",'"',urlencode($value));
		}
	}
	return $temp;
}
function yding_error($message="", $code=null){
	return array('success'=> false, "data"=>null,"msg"=>$message);
}

function yding_success($data=null){
	return array('success'=> true, "data"=>$data,"msg"=>null);
}
/**
 * yding 接口参数基类
 * 
 * @author leeboo
 *
 */
abstract class YDingRequest{
    public $sign;
    public function __toString(){
        return $this->toString();
    }
    /**
     * 根据设置的属性及接口参数要求验证、构建数据，有问题抛出YDing_Exception
     * 这是在toString，toJSONString，toXMLString之前会调用的一步
     */
    public abstract function valid();
    
    public static function ignoreNull(array $args){
        $array = array();
        foreach($args as $name=>$value){
            if(is_array($value)){
                $array[$name] = YDingRequest::ignoreNull($value);
            }else if( ! is_null($value)){
                $array[$name] = $value;
            }
        }
        return $array;
    }
    /**
     * 使用URL键值对的格式（即key1=value1&key2=value2…）拼接成字符串，
     * 注意这里返回的字符串是urlencode格式的，在某些签名场合注意urldecode出原内容
     * @return string
     */
    public function toString(){
        $this->valid();
        $args = YDingRequest::ignoreNull($this->sortArg());
        return http_build_query($args);
    }
    public function toJSONString(){
        $this->valid();
        $args = YDingRequest::ignoreNull($this->sortArg());
        return yding_json_encode($args);
    }
    public function toArray(){
        $this->valid();
        return YDingRequest::ignoreNull($this->sortArg());
    }
    public function toXMLString(){
        $this->valid();
        $args = YDingRequest::ignoreNull($this->sortArg());
        
        $xml = "<xml>";
        foreach ($args as $name=>$value){
            if(is_array($value)){
                $xml .= "<{$name}>".$this->arrayToXml($value)."</{$name}>";
            }else{
                $xml .= "<{$name}><![CDATA[{$value}]]></{$name}>";
            }
        }
        return $xml."</xml>";
    }
    private function arrayToXml($array){
        $xml = "";
        foreach($array as $key => $value){
            if( ! is_numeric($key)){
                $xml .= "<{$key}>";
            }
            if( is_array($value)){
                $xml .= $this->arrayToXml($value);
            }else{
                $xml .= "<![CDATA[$value]]>"; 
            }
            if( ! is_numeric($key)){
                $xml .= "</{$key}>";
            }
        }
        return $xml;
    }
    /**
     * 构建自己的数据结构，默认实现是把所有的非null属性组成数组返回
     * @return multitype:
     */
    protected function formatArgs(){
        return YDingRequest::ignoreNull(get_object_vars($this));
    }
    /**
     * 返回按字典排序后的属性数组,排序依据是key; 如果接口不需要排序，子类重载该方法
     */
    public function sortArg(){
        $args = $this->formatArgs();
        ksort($args);
        return $args;
    }
    /**
     * 根据具体的api请求进行签名
     */
    public function sign(){
        
    }
}

class YDing_Exception extends \Exception{
	public function __construct($message=null, $code=null, $previous=null){
		parent::__construct($message, $code, $pre);
	}
}

/**
 * 消息封装基类,便于知道每种消息有什么内容
 */
class YDingResponse{
    /**
     * 真值表示有错误
     * @var unknown
     */
    public $errcode;
    public $errmsg;
    public $rawData;
    
    
    public function __construct($msg=null){
        if($msg){
        	$this->rawData = $msg;
            $this->build($msg);
        }
    }
    /**
     * @return 返回bool值，表示业务处理成功
     */
    public function isSuccess(){
        return  ! $this->errcode;
    }
    /**
     * 解析消息,默认以json字符串进行解析；错误返回格式：{"errcode":,"errmsg":""}
     * 
     * @param string $msg
     */
    public function build($msg){
        $info = json_decode($msg, true);
        if($info){
            foreach ($info as $name => $value){
                $this->$name = $value;
            }
            if($this->errcode){
                $this->errmsg .= "(".$this->errcode.")";
            }
        }else{
            $this->errcode = -1;
            $this->errmsg  = "响应字符串格式不对（{$msg}）";
        }
    }
}