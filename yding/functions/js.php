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
                'biz.util.openLink',
                'biz.chat.open',
                'biz.ding.post',
                'biz.util.open',
                'biz.util.share',
                'biz.user.get',
                'biz.contact.choose',
                'biz.telephone.call',
                'biz.ding.post',
                'biz.navigation.setLeft',
                'biz.navigation.setRight',
                'biz.navigation.setMenu',
                'biz.navigation.setTitle']
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
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_jsapi_open_profile(userid, corpid);
        },
        100);
        return;
    }
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
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_jsapi_alert(msg, title, btnName);
        },
        100);
        return;
    }
	yding.device.notification.alert({
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
    
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_jsapi_open_share(url, title, content, image);
        },
        100);
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

/**
 * 输出yding_navigation_set_title(name)
 */
function yding_navigation_set_title(){
?>
function yding_navigation_set_title(title){
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_navigation_set_title(title);
        },
        100);
        return;
    }
	yding.biz.navigation.setTitle({
	    title : title,//控制标题文本，空字符串表示显示默认文本
	    onSuccess : function(result) {
	        /*结构
	        {
	        }*/
	    },
	    onFail : function(err) {}
	});
}
<?php 
}

/**
 * 输出yding_navigation_set_left(show, inControl, showIcon, text, onclick)
 * show：控制按钮显示， true 显示， false 隐藏， 默认true
 * inControl 是否控制点击事件，true 控制，false 不控制， 默认false
 * showIcon 是否显示icon，true 显示， false 不显示，默认true； 注：具体UI以客户端为准
 * text 控制显示文本，空字符串表示显示默认文本
 * onclick：方法名或者匿名方法，当inControl为true时，点击按钮后会调用该方法
 * 
 */
function yding_navigation_set_left(){
	?>
function yding_navigation_set_left(show, inControl, showIcon, text, onclick){
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_navigation_set_left(show, inControl, showIcon, text, onclick);
        },
        100);
        return;
    }

	yding.biz.navigation.setLeft({
	    show: show,//控制按钮显示， true 显示， false 隐藏， 默认true
	    control: inControl,//是否控制点击事件，true 控制，false 不控制， 默认false
	    showIcon: showIcon,//是否显示icon，true 显示， false 不显示，默认true； 注：具体UI以客户端为准
	    text: text,//控制显示文本，空字符串表示显示默认文本
	    onSuccess : function(result) {
	        if(typeof onclick == "function"){
	           onclick(result);
            }else{
                window[onclick](result);
            }
	    },
	    onFail : function(err) {}
	});
}
<?php 
}

/**
 * 输出yding_navigation_set_right(show, inControl, showIcon, text, onclick)
 * show：控制按钮显示， true 显示， false 隐藏， 默认true
 * inControl 是否控制点击事件，true 控制，false 不控制， 默认false
 * text 控制显示文本，空字符串表示显示默认文本
 * onclick：方法名或者匿名方法，当inControl为true时，点击按钮后会调用该方法
 *
 */
function yding_navigation_set_right(){
	?>
function yding_navigation_set_right(show, inControl, text, onclick){
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_navigation_set_right(show, inControl, text, onclick);
        },
        100);
        return;
    }
	yding.biz.navigation.setRight({
	    show: show,//控制按钮显示， true 显示， false 隐藏， 默认true
	    control: inControl,//是否控制点击事件，true 控制，false 不控制， 默认false
	    text: text,//控制显示文本，空字符串表示显示默认文本
	    onSuccess : function(result) {
	        //如果control为true，则onSuccess将在发生按钮点击事件被回调
            if(typeof onclick == "function"){
	           onclick(result);
            }else{
                window[onclick](result);
            }
	    },
	    onFail : function(err) {}
	});
}
<?php 
}

/**
 * 输出yding_contact_choose(departmentid, multiple, users, callback)
 *  //departmentid -1表示打开的通讯录从自己所在部门开始展示, 0表示从企业最上层开始，(其他数字表示从该部门开始:暂时不支持)
 *  //multiple是否多选： true多选 false单选； 默认true
 *  //users [String, String, ...] 默认选中的用户列表，userid；成功回调中应包含该信息
 *  //corpId 企业id
 *  //max 人数限制，当multiple为true才生效，可选范围1-1500
 *  //callback回调函数和匿名函数，传入参数
	    [{
	      "name": "张三", //姓名
	      "avatar": "http://g.alicdn.com/avatar/zhangsan.png" //头像图片url，可能为空
	      "emplId": '0573', //userid
	     },
	     ...
	    ]
 */
function yding_contact_choose(){
?>
function yding_contact_choose(corpId, departmentid, multiple, max, users, callback){
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_contact_choose(corpId, departmentid, multiple, max, users, callback);
        },
        100);
        return;
    }
	yding.biz.contact.choose({
	  startWithDepartmentId: departmentid,
	  multiple: multiple,
	  users: users, 
	  corpId: corpId,
	  max: max, 
	  onSuccess: function(data) {
        if(typeof callback == "function"){
	           callback(data);
        }else{
                window[callback](data);
        }
	  },
	  onFail : function(err) {
        yding_jsapi_alert(err, "选择联系人失败", "知道了");
      }
	});
}
<?php 
}

/**
 * 输出发送图片 ding消息接口
 * uids: ['100', '101'],//用户列表，工号
 * corpid:企业id
 * imgs: 图片地址数组['url1','url2']
 * text: 消息内容
 * alertType:钉提醒类型 0:电话, 1:短信, 2:应用内
 * alertDate:钉提醒时间 格式yyyy-MM-dd HH:mm
 * yding_ding_image_post(uids, corpid, type, text, alertType, alertDate)
 */
function yding_ding_image_post(){
	?>
function yding_ding_image_post(uids, corpid, imgs, text, alertType, alertDate){
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_ding_image_post(uids, corpid, imgs, text, alertType, alertDate);
        },
        100);
        return;
    }
	yding.biz.ding.post({
	    users : uids
	    corpId: corpid,
	    type: 1,
	    alertType: parseInt(alertType),
	    alertDate: {"format":"yyyy-MM-dd HH:mm","value":alertDate},
	    attachment: {
	        images: imgs,
	    },
	    text: text,
	     onSuccess : function() {
            //yding_jsapi_alert("成功", "图片Ding消息成功", "知道了");
	    },
	    onFail : function(arg) {
            yding_jsapi_alert(arg, "图片Ding消息失败", "知道了");
        }
	});
}
<?php 
}
/**
 * 输出发送链接 ding消息接口
 * uids: ['100', '101'],//用户列表，工号
 * corpid:企业id
 * imgs: 图片地址数组['url1','url2']
 * text: 消息内容
 * alertType:钉提醒类型 0:电话, 1:短信, 2:应用内
 * alertDate:钉提醒时间 格式yyyy-MM-dd HH:mm
 * yding_ding_image_post(uids, corpid, type, text, alertType, alertDate)
 */
function yding_ding_link_post(){
	?>
function yding_ding_link_post(uids, corpid, linkTitle, linkUrl, linkImg, linkText, text, alertType, alertDate){
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_ding_link_post(uids, corpid, linkTitle, linkUrl, linkImg, linkText, text, alertType, alertDate);
        },
        100);
        return;
    }
	yding.biz.ding.post({
	    users : uids,
	    corpId: corpid,
	    type: 2,
	    alertType: parseInt(alertType),
	    alertDate: {"format":"yyyy-MM-dd HH:mm","value":alertDate},
	    attachment: {
	        title: linkTitle,
	        url: linkUrl,
	        image: linkImg,
	        text: linkText
	    },
	    text: text,
	    onSuccess : function() {
            //yding_jsapi_alert("成功", "链接Ding消息成功", "知道了");
	    },
	    onFail : function(arg) {
            yding_jsapi_alert(arg, "链接Ding消息失败", "知道了");
        }
	});
}
<?php 
}

/**
 * 打开新连接yding_open_link(link)
 */
function yding_open_link(){
    ?>
function yding_open_link(link){
    if( ! ydingIsConfiged){
        setTimeout(function(){
            yding_open_link(link);
        },
        100);
        return;
    }
    yding.biz.util.openLink({
        url: link,
        onSuccess : function(result) {
        },
        onFail : function() {}
    });
}
<?php 
}
?>