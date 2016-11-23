<?php
/**
 * 输出移动端dingtalk.js
 * @author leeboo
 */
function yding_jsapi_init(){
?>
<script type="text/javascript" src="https://g.alicdn.com/ilw/ding/0.9.2/scripts/dingtalk.js"></script>
<?php 
}
/**
 * 输出PC端dingtalk.js
 * @author leeboo
 */
function yding_pc_jsapi_init(){
	?>
<script type="text/javascript" src="http://g.alicdn.com/dingding/dingtalk-pc-api/2.5.0/index.js"></script>
<?php 
}

/**
 * jsapi权限验证配置
 * 
 * @param unknown $agentid
 * @param unknown $corpid
 * @param unknown $timestamp
 * @param unknown $noncestr
 * @param unknown $signature
 * @param unknown $jsapi_type 服务窗时1，其他是0
 */
function yding_jsapi_config($agentid, $corpid, $timestamp, $noncestr, $signature, $jsapi_type){
?>
    var ydingIsConfiged = false;
    var yding ;
    if((typeof dd)=="undefined"){
        yding = DingTalkPC;
    }else{
        yding = dd;
    }
    yding.config({
            agentId: "<?php echo $agentid?>",
            corpId:  "<?php echo $corpid?>",
            timeStamp: "<?php echo $timestamp?>",
            nonceStr: "<?php echo $noncestr?>",
            signature: "<?php echo $signature?>",
            type: <?php echo intval($jsapi_type)?>,
            jsApiList: [
                'runtime.info',
                'device.notification.prompt',
                'biz.chat.pickConversation',
                'device.notification.confirm',
                'device.notification.alert',
                'device.notification.prompt',
                'biz.chat.open',
                'biz.util.open',
                'biz.util.share',
                'biz.user.get',
                'biz.contact.choose',
                'biz.telephone.call',
                'biz.ding.post']
        });
        
        yding.ready(function() {
            ydingIsConfiged = true;
        });

        yding.error(function(err) {
            ydingIsConfiged = false;
            alert(err.message);
        });
<?php 
}

/**
 * 输出yding_jsapi_open_profile(userid, corpid) js函数，该函数用于调起用户个人资料页
 */
function yding_jsapi_open_profile(){
?>
function yding_jsapi_open_profile(userid, corpid){
	yding.biz.util.open({
		name:"profile",
		params:{
            id: userid,
            corpId: corpid
        },
		onSuccess : function() {},
		onFail : function(err) {}
	});
}
<?php 
}

/**
 * 输出yding_jsapi_alert(msg, title, btnName) js函数，该函数用于输出弹窗
 */
function yding_jsapi_alert(){
?>
function yding_jsapi_alert(msg, title, btnName){
	DingTalkPC.device.notification.alert({
	    message: msg,
	    title: title,
	    buttonName: btnName,
	    onSuccess : function() {
	        /*回调*/
	    },
	    onFail : function(err) {}
	});
}
<?php 
}

/**
 * 输出yding_jsapi_open_share(url, title, content, image) js函数，该函数用于调起分享
 */
function yding_jsapi_open_share(){
	?>
function yding_jsapi_open_share(url, title, content, image){
    if( ! yding.biz.util.share){
        DingTalkPC.device.notification.alert({
	        message: "PC端不支持分享功能",
	        title: "OOPs",
	        buttonName: "知道了",
	        onSuccess : function() {
	        },
	        onFail : function(err) {}
	    });
        return;
    }
	yding.biz.util.share({
	    type: 0,
	    url: url,
	    title: title,
	    content: content,
	    image: image,
	    onSuccess : function() {},
	    onFail : function(err) {}
	})
}
<?php 
}
?>