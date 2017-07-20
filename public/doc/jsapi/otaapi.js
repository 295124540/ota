/**
 * API接口定义 服务器，接口方法，接口参数及说明，测试数据，
 */
var bxsAPI = {};
bxsAPI.local = location.host=="saas.com"? 0 : 1;
bxsAPI.apis = [];
bxsAPI.server = bxsAPI.local?"http://saas.icloudinn.com":"http://saas.com";
bxsAPI.uid = bxsAPI.local?"22497":"22497";
bxsAPI.un = "13552997366";
bxsAPI.token = {
	field:"access-token",
	value:"ZBy0YkZOIS6K9RFQINlPcdmnGtV_UOwR-1Wuufem"
}
bxsAPI.page={
	curPage:{field:"page",default:1},//当前页
	eachPageSize:{field:"per-page",default:20}//每页显示条数
};
bxsAPI.ziruo = "false";

bxsAPI.returnCodes={
	isOK:{0:"Unknown Error",100:"success"},
	tokenErr:{101:"token已过期"},
	paramsErr:{200:"xxx参数缺失"}
};

bxsAPI.readme = "奔格内书宿，本系统采用TinkPHP5.0.9框架编写，API接口严格遵循RESTful Web API风格。<br> " +
	"本程序中变量使用驼峰命名法，数据库中的字段采用下划线分割来命名。<br>" +
	"接口授权认证，access-token 作为请求头发送给用户端<br>" +
	"后台：<a target='_blank' href='http://qz.icloudinn.com/admin'>http://ys.icloudinn.com/admin</a><br>" +
	"后台：<a target='_blank' href='http://admin.saas.icloudinn.com'>http://admin.saas.icloudinn.com</a><br>" +
	"正式环境<redlight>小镇演义公众号:<br></redlight>appId =wx4a150a2811c36060；appSecret=e89b2cea1a76897f8632a33963b39a56<br>" +
	"测试环境<redlight>云游直播公众号:<br></redlight>appId =wx59f95d5febc26d71；appSecret=8b2e0096bd11843852f3d95f19b4dd9c<br>";

// API最新版本号，更新需要调整版本号，并更新下面的记录
bxsAPI.version = "v1.0";
bxsAPI.updated = [ {
	ver : "v1.0",
	dt : "2016-11-01",
	con : [ "基础接口（某个接口的版本升级了，不会影响原来的版本）" ]
}, {
	ver : "v2.0",
	dt : "2017-03-01",
	con : [
		"<a href='#/product_consultalist'></a>由腾讯频道托管换成直播码接入，状态通知</br>",
		"<a href='#4_0'>创建直播间</a>（换成直播码接入）"
	]
}, ];

/**
 * 接口模块定义 主要用于分类接口，看起来更清楚
 */

bxsAPI.apicates = [// api模块
	{
		cid : 1,
		name : "公共（无需登录）"
	},
	{
		cid : 2,
		name : "首页"
	},
	{
		cid : 9,
		name : "签名"
	},
	{
	cid : 3,
	name : "用户"
	},
	{
		cid : 4,
		name : "商户"
	},
	{
		cid : 5,
		name : "直播"
	},
	{
		cid : 6,
		name : "统计分析"
	},
	{
		cid : 7,
		name : "素材资源"
	},
	{
		cid : 8,
		name : "充值提现"
	}
];

bxsAPI.apis.push({
	cid : 1,
	name : "游客获取直播间",
	url: "/api/v1/deals/room/156",
	method : "GET",
	desc : "获取商户的直播间详情",
	returns : roomAPIReturns,
});
bxsAPI.apis.push({
	cid : 1,
	name : "房间重置",
	url: "/api/v1/deal/room-reset",
	method : "POST",
	params : [
		{field:"room_id",isrequire:true,desc:"房间ID",sample:"23423345"},
	],
	desc : "房间推流地址存在无法推流，或者播放地址无法正常播放时，请执行该接口，重置修复该房间的推流地址和播放地址！",
});
bxsAPI.apis.push({
	cid : 1,
	name : "数据字典",
	url: "/api/v1/deal/data-dictionary",
	method : "GET",
	desc : "数据库的数据字典详细解析",
});
//------------------------------end-------------cid1----------------------------------------------


bxsAPI.apis.push({
	cid : 2,
	name : "商户的直播概况",
	url: "/api/v1/analyze/live-infor",
	method : "GET",
	auth:"商户",
	desc : "商户的直播概况",
	returns : {
		"live_num":"总直播场数",
		"watch_num":"总观看人数",
		"income":"直播收益"
	},
});
//------------------------------end-------------cid2----------------------------------------------
bxsAPI.apis.push({
	cid : 3,
	name : "微信登录",
	url: "/api/v1/deals/wxlogin",
	method : "POST",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"code",isrequire:true,desc:"微信的code",sample:"23423sdd"},
	],
	desc : "该微信登录是小镇演义的公众号授权。",
	returns : {
		code : "状态值",
		msg : "提示",
		data : "返回的数据 数据列表",
	}
});

bxsAPI.apis.push({
	cid : 3,
	name : "直播间列表",
	url: "/api/v1/consumer",
	method : "GET",
	auth:"微信用户",
	desc : "微信用户获取直播间列表。组合查询方式显示。",
	returns : {
		hls_downstream_address : "状态值",
		flv_downstream_address : "提示",
		rtmp_downstream_address : "返回的数据 数据列表",
		rtmp_downstream_address : "返回的数据 数据列表",
		plugin : "房间自定义菜单"
	}
});
bxsAPI.apis.push({
	cid : 3,
	name : "进入直播间",
	url: "/api/v1/consumers/room/10",
	method : "GET",
	auth:"微信用户",
	desc : "获取商户的直播间详情",
	returns : {
		code : "状态值",
		msg : "提示",
		data : "返回的数据 数据列表",
	}
});
bxsAPI.apis.push({
	cid : 3,
	name : "保持房间心跳",
	url: "/api/v1/consumers/heartbeat",
	method : "POST",
	auth:"微信用户",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"roomid",isrequire:true,desc:"房间ID",sample:"10"},
		{field:"heartid",isrequire:true,desc:"心跳ID",sample:"123456"},
	],
	desc : "2分钟请求1次，当服务器在大于3分钟没有收到用户端的请求，会自动停止计时，认为该用户已经异常退出房间。",
	returns : {
		code : "状态值",
		msg : "提示",
		data : "返回的数据 数据列表",
	}
});
bxsAPI.apis.push({
	cid : 3,
	name : "退出直播间",
	url: "/api/v1/consumers/exitroom/10",
	method : "GET",
	auth:"微信用户",
	desc : "退出该直播间",
	returns : {
		code : "状态值",
		msg : "提示",
		data : "返回的数据 数据列表",
	}
});
bxsAPI.apis.push({
	cid : 3,
	name : "查询观众观看权限",
	url: "/api/v1/income/search-watch-auth",
	method : "POST",
	auth:"微信用户",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"room_id",isrequire:true,desc:"房间ID",sample:"10"},
	],
	desc : "查询观众是否支付该房间的观看费用，<redlight>目前只支持付费方式</redlight>",
	returns : {
		watch_auth_way : "授权观看方式。pay_bill：付费观看",
		is_paid : "是否已支付",
		is_allow: "是否授权"
	}
});

//------------------------------end-------------cid3----------------------------------------------
bxsAPI.apis.push({
	cid : 4,
	name : "商户注册",
	url: "/api/v1/user/register",
	method : "POST",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"account",isrequire:true,desc:"账号/公司企业邮箱",sample:"admin"},
		{field:"pwd",isrequire:true,desc:"密码",sample:"123456"},
		{field:"company",isrequire:true,desc:"公司全称",sample:"海口云宿乡土网络科技有限公司"},
		{field:"contacts",isrequire:true,desc:"联系人姓名",sample:"张小明"},
		{field:"contacts_phone",isrequire:true,desc:"联系人电话",sample:"13006022705"},
	],
	desc : "创建直播房间，本接完成房间创建和聊天室创建，聊天室ID请用频道ID。",
	returns : {
		account : "账号",
		email : "公司企业邮箱",
		access_token : "登录令牌",
	}
});
bxsAPI.apis.push({
	cid : 4,
	name : "登录获取Token",
	url: "/api/v1/users",
	method : "POST",
	auth:"商户",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"account",isrequire:true,desc:"账号/公司企业邮箱",sample:"admin"},
		{field:"pwd",isrequire:true,desc:"密码",sample:"123456"},
	],
	desc : "创建直播房间，本接完成房间创建和聊天室创建，聊天室ID请用频道ID。",
	returns : {
		account : "账号",
		email : "公司企业邮箱",
		access_token : "登录令牌",
	}
});
bxsAPI.apis.push({
	cid : 4,
	name : "商户个人信息",
	url: "/api/v1/users",
	method : "GET",
	auth:"商户",
	desc : "商户个人详细信息。",
	returns : {
		account : "账号",
		email : "公司企业邮箱",
		balance : "余额",
		contacts : "联系人",
		contacts_phone : "联系人电话",
	}
});
bxsAPI.apis.push({
	cid : 4,
	name : "商户的直播收益",
	url: "/api/v1/income/my-income",
	method : "GET",
	auth:"商户",
	ispage:true,
	desc : "商户个人详细信息。",
	returns : {
		total_income : "总收益",
		income_balance : "收益余额",
		pay_income : "支付收益",
		dashang_income : "打赏收益",
		hongbao_income : "红包收益",
		total_income:"该房间的总收益"
	}
});
bxsAPI.apis.push({
	cid : 4,
	name : "收益详情",
	url: "/api/v1/income",
	method : "GET",
	auth:"商户",
	ispage:true,
	urlparams : [
		{field:"room_id",isrequire:false,desc:"房间ID",sample:"33"},
		{field:"origin",isrequire:false,desc:"收益来源 1:支付 2：打赏 3：红包",sample:"1"},
	],
	desc : "收益详情，可按不同的参数，自己进行组合",
});
//------------------------------end-------------cid4----------------------------------------------
var roomAPIReturns = {
	plugin:"直播间菜单配置",
		upstream_address:"推流地址",
		hls_downstream_address:"直播地址，不支持手机H5播放器，延时低，3s左右",
		flv_downstream_address:"直播地址，不支持手机H5播放器，延时低，3s左右",
		rtmp_downstream_address:"直播地址，支持手机H5播放器，延时高，10s左右",
		status : "0无输入流;1直播中;2异常;3关闭<br><redlight>该状态无法及时和腾讯服务器数据同步，慎重使用，不得不使用的情况下，请直接使用腾讯的接口</redlight>",
};
bxsAPI.apis.push({
	cid : 5,
	name : "创建直播间",
	url: "/api/v1/rooms",
	method : "POST",
	auth:"商户",
	body:"<redlight>[raw]</redlight>JSON(application/json)",
	params : [
		{field:"title",isrequire:true,desc:"标题",sample:"万洲的直播间"},
		{field:"cover_img_url",isrequire:true,desc:"封面图片地址",sample:"2.png"},
		{field:"is_record_play",isrequire:false,desc:"是否录播",sample:0},
	],
	desc : "创建直播房间，本接完成房间创建和聊天室创建，聊天室ID请用频道ID。",
	returns : roomAPIReturns,
});

bxsAPI.apis.push({
	cid : 5,
	name : "直播间列表",
	url: "/api/v1/rooms",
	method : "GET",
	auth:"商户",
	ispage:true,
	desc : "获取商户的直播间列表",
	returns : {
		"video_live_way":"点播总开关，0:都关闭 1：只开启视频直播 2：只开启预告回放",
	},
});

bxsAPI.apis.push({
	cid : 5,
	name : "直播间详情",
	url: "/api/v1/rooms/156",
	method : "GET",
	auth:"商户",
	desc : "获取商户的直播间详情",
	returns : {
		"video_live_way":"点播总开关，0:都关闭 1：只开启视频直播 2：只开启预告回放",
	},
});

bxsAPI.apis.push({
	cid : 5,
	name : "直播间修改：配置、观看权限",
	url: "/api/v1/rooms/100",
	method : "PUT",
	auth:"商户",
	body:"<redlight>[raw]</redlight>JSON(application/json)",
	params : [
		{field:"title",isrequire:false,desc:"标题",sample:"万洲的直播间"},
		{field:"cover_img_url",isrequire:false,desc:"封面图片地址",sample:"2.png"},
		{field:"is_record_play",isrequire:false,desc:"是否录播",sample:0},
		{field:"video_is_repeat_play",isrequire:false,desc:"点播视频是否循环播放：0 否；1 是",sample:0},
		{field:"video_live_way",isrequire:false,desc:"是否打开点播作为直播方式总开关<br> 0：全部关闭；1：预告\\回放开启；2：普通点播设置为直播开启",sample:0},
		{field:"watch_permission",isrequire:false,desc:"观看权限方式。1：限制人数方式 2：密码方式 3：付费方式",sample:0},
		{field:"room_password",isrequire:false,desc:"房间观看密码，只能为6位的数字，当null时房间没有设置密码。",sample:0},
		{field:"watch_pay_bill",isrequire:false,desc:"付费观看，当null时不需要付费观看。",sample:0},
		{field:"watch_num_limit",isrequire:false,desc:"观看人数限制，当null时无人数限制。",sample:0},
		{field:"share_img_url",isrequire:false,desc:"用于分享的图片地址",sample:""},
		{field:"share_intro",isrequire:false,desc:"用于分享的文本信息",sample:""},
	],
	desc : "修改直播间，直播间ID参数见/api/v1/rooms/100。直播间配置修改",
	returns : {
			"video_live_way":"点播总开关，0:都关闭 1：只开启视频直播 2：只开启预告回放",
		    "video_is_repeat_play":"点播视频是否循环播放",
			"watch_permission":"观看权限方式。1：限制人数方式 2：密码方式 3：付费方式",
		    "room_password":"房间观看密码,当null时房间没有设置密码",
		    "watch_pay_bill":"付费观看,当null时不需要付费观看",
		    "watch_num_limit":"观看人数限制,当null时无人数限制"
	},
});

bxsAPI.apis.push({
	cid : 5,
	name : "直播间删除",
	url: "/api/v1/rooms/10",
	method : "DELETE",
	auth:"商户",
	desc : "获取商户的直播间列表",
	retuCode:{
		234:"dd"
	}
});

//------------------------------end-------------cid5----------------------------------------------
bxsAPI.apis.push({
	cid : 6,
	name : "某直播间-观众列表统计",
	url: "/api/v1/analyzes/audience/room/2",
	method : "GET",
	auth:"商户",
	urlparams : [
		{field:"orderby",isrequire:false,desc:"排序 enter_time:进入时间(默认)  province:省份",sample:"enter_time"},
		{field:"type",isrequire:false,desc:"方式 DESC:(默认) ASC:升序 ",sample:"DESC"},
	],
	desc : "某房间观看人数统计",
	ispage:true,
	returns : {
		"province" : "省份",
		"enter_time": "进入房间时间",
		"out_time": "退出房间时间",
		"total_time": "观看时间"
	}
});
bxsAPI.apis.push({
	cid : 6,
	name : "数据分析(概况、实时、地域)",
	url: "/api/v1/analyzes/data/room/2",
	method : "POST",
	auth:"商户",
	params : [
		{field:"time_slot",isrequire:false,desc:"时间段 【0全部(默认)；1今天；2昨天；3本周；4上周；5本月；6上月】",sample:"1"},
	],
	desc : "查询指定直播间的直播基本情况、实时数据分析、观众区域统计,接口中的时间精确到分钟。",
	returns : {
		"situation": "直播概况",
		"real_time_num": "实时在线人数分布</redlight>",
		"area": "观众地域分布",
	}
});

//------------------------------end-------------cid6----------------------------------------------

bxsAPI.apis.push({
	cid : 7,
	name : "图片列表",
	url: "/api/v1/materials/picture/list",
	method : "GET",
	auth:"商户",
	ispage:true,
	desc : "获取商户的直播间详情",
	returns : {
		merchant_id : "商户ID",
		catalogue : "素材目录",
		img_url : "图片素材url",
	}
});
bxsAPI.apis.push({
	cid : 7,
	name : "删除图片",
	url: "/api/v1/materials/12",
	method : "DELETE",
	auth:"商户",
	desc : "删除图片",
});

bxsAPI.apis.push({
	cid : 7,
	name : "确认视频成功上传",
	url: "/api/v1/videos",
	method : "POST",
	auth:"商户",
	params : [
		{field:"room_id",isrequire:true,desc:"房间ID",sample:"100"},
		{field:"file_id",isrequire:true,desc:"存储视频文件ID",sample:"9031868222888327850"},
	],
	desc : "当前端完成视频上传腾讯云时，必须给自己应用服务器确认上传成功信息",
	returns : {
		id : "数据表记录ID",
		merchant_id : "商户ID",
		file_id : "存储视频文件ID",
	}
});

bxsAPI.apis.push({
	cid : 7,
	name : "视频列表",
	url: "/api/v1/videos",
	method : "GET",
	auth:"商户",
	ispage:true,
	urlparams : [
		{field:"room_id",isrequire:false,desc:"房间ID，不传则是该用户全部视频列表",sample:"79"},
		{field:"store_way",isrequire:false,desc:"视频存储方式 1:暂存 2：永存（视频库），不传则是两者都有",sample:"1"},
		{field:"set_live_way",isrequire:false,desc:"点播做为直播的方式，0:没有作为直播 1：视频直播 2：预告回放",sample:"79"},
	],
	desc : "获取视频列表",
	returns : {
		id : "数据表记录ID",
		merchant_id : "商户ID",
		server_file_id : "存储视频文件ID",
		store_way:"视频存储方式 1:暂存 2：库存",
		set_live_way:"0:都没有 1：视频直播 2：预告回放"
	}
});
bxsAPI.apis.push({
	cid : 7,
	name : "视频详情",
	url: "/api/v1/videos/50",
	method : "GET",
	auth:"商户",
	desc : "获取视屏详情",
	returns : {
		id : "数据表记录ID",
		merchant_id : "商户ID",
		server_file_id : "存储视频文件ID",
		store_way:"视频存储方式 1:暂存 2：库存",
		set_live_way:"0:都没有 1：视频直播 2：预告回放"
	}
});

bxsAPI.apis.push({
	cid : 7,
	name : "修改视频信息",
	url: "/api/v1/videos/50",
	method : "PUT",
	auth:"商户",
	params : [
		{field:"file_name",isrequire:false,desc:"视频文件名称",sample:"海口前端开发培训"},
		{field:"store_way",isrequire:false,desc:"视频存储方式：1：暂存 2：永存（视频库），只能从暂存到永存，前端自己限制",sample:"2"}
	],
	desc : "转入视频库，修改视频名称",
	returns : {
		id : "数据表记录ID",
		merchant_id : "商户ID",
		server_file_id : "存储视频文件ID",
		store_way:"视频存储方式 1:暂存 2：库存",
		set_live_way:"0:都没有 1：视频直播 2：预告回放"
	}

});

bxsAPI.apis.push({
	cid : 7,
	name : "删除视频",
	url: "/api/v1/videos/50",
	method : "DELETE",
	auth:"商户",
	desc : "根据ID删除视频",
});

bxsAPI.apis.push({
	cid : 7,
	name : "批量删除视频",
	url: "/api/v1/video/del-videos",
	method : "POST",
	auth:"商户",
	params : [
		{field:"ids",isrequire:true,desc:"要删除的ID数组",sample:"[12,34,45]"},
	],
	desc : "根据多个ID批量删除视频",
});

bxsAPI.apis.push({
	cid : 7,
	name : "把点播视频设置为直播",
	url: "/api/v1/video/set-video-live",
	method : "POST",
	auth:"商户",
	params : [
		{field:"video_id",isrequire:true,desc:"视频ID",sample:"79"},
		{field:"room_id",isrequire:true,desc:"直播间ID",sample:"79"},
		{field:"set_live_way",isrequire:true,desc:"设置直播方式。0：没有；1：视频直播；2：预告\\回放",sample:"1"},
	],
	desc : "给某直播间设置点播视频",

});

bxsAPI.apis.push({
	cid : 7,
	name : "手动重新转码",
	url: "/api/v1/video/trans-code",
	method : "POST",
	auth:"商户",
	params : [
		{field:"file_id",isrequire:true,desc:"文件ID（注意不是视频ID）",sample:"334345dsfdsdfsde53"},
	],
	desc : "当你上传完视频，服务端会自动转码，录制完成时，服务端会请求腾讯云服务器进行视频转码。但是腾讯云在转码过程中，" +
	"会存在转码失败的情况，这时当前端检查到play_set字段为空时，说明转码是失败的，需要前端请求转码接口，重新转码。",

});

//------------------------------end-------------cid7----------------------------------------------

bxsAPI.apis.push({
	cid : 8,
	name : "APP、公众号吊起微信支付",
	url: "/api/v1/pay/wx-pay",
	method : "POST",
	auth:"商户",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"merchant_id",isrequire:true,desc:"商户ID",sample:80},
		{field:"room_id",isrequire:true,desc:"房间ID",sample:123},
		{field:"trade_type",isrequire:true,desc:"1:应用APP支付，2:微信公众号支付",sample:"1"},
		{field:"action",isrequire:true,desc:"支付意图。live_watch：直播观看  dashang：观众打赏  hongbao：红包领取",sample:"1"},
		{field:"money",isrequire:true,desc:"支付金额",sample:"0.01"},
	],
	desc : "余额充值、套餐购买",
	returns : {
		appId: "应用APPID",
		timeStamp: "时间戳",
		nonceStr: "随机串",
		package: "预付订单ID",
		signType: "签名方式",
		paySign: "签名"
	}
});

bxsAPI.apis.push({
	cid : 8,
	name : "微信扫码支付",
	url: "/api/v1/pays/wechat",
	method : "POST",
	auth:"商户",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"money",isrequire:true,desc:"支付金额",sample:0.01},
		{field:"action",isrequire:false,desc:"支付动作。recharge：余额充值(默认)；buy_meal：套餐购买；account_upgrade：账户升级",sample:"buy_meal"},
		{field:"meal_id",isrequire:false,desc:"套餐ID（购买套餐时必填，只能为正整数1，2，3...）",sample:"1"},
		{field:"live_duration",isrequire:false,desc:"直播时长（购买套餐时必填）",sample:"5000"},
		{field:"account_type",isrequire:false,desc:"用户类型（用户升级时必填）1:高级用户；2：普通用户",sample:"5000"},
	],
	desc : "余额充值、套餐购买",
	returns : {
		tradeId : "微信支付交易ID",
		payurl : "微信支付二维码地址，将此地址生成二维码。",
	}
});

bxsAPI.apis.push({
	cid : 8,
	name : "支付宝扫码支付",
	url: "/api/v1/pays/alipay",
	method : "POST",
	auth:"商户",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"money",isrequire:true,desc:"支付金额",sample:0.01},
		{field:"return_url",isrequire:false,desc:"支付成功回调地址,（默认http://icloudinn.live/#/pay）。请填写以http://开头可以访问的地址，否则无法正常支付",sample:"http://icloudinn.live/#/pay"},
		{field:"action",isrequire:false,desc:"支付动作。recharge：余额充值(默认)；buy_meal：套餐购买；account_upgrade：账户升级",sample:"buy_meal"},
		{field:"meal_id",isrequire:false,desc:"套餐ID（购买套餐时必填，只能为正整数1，2，3...）",sample:"套餐A"},
		{field:"live_duration",isrequire:false,desc:"直播时长（购买套餐时必填）",sample:"5000"},
		{field:"account_type",isrequire:false,desc:"用户类型（用户升级时必填）1:高级用户；2：普通用户",sample:"5000"},
	],
	desc : "余额充值",
	returns : {
		tradeId : "交易ID",
		payurl : "支付宝支付地址",
	}
});

bxsAPI.apis.push({
	cid : 8,
	name : "充值支付状态查询",
	url: "/api/v1/pays/alipay",
	method : "POST",
	auth:"商户",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"tradeId",isrequire:false,desc:"交易ID",sample:"dsds2343njh"},
		{field:"payType",isrequire:false,desc:"支付方式。1：微信；2：支付宝",sample:1}
	],
	desc : "余额充值支付状态查询",
	returns : {
		record_no : "记录编号",
		after_balance : "充值后的余额",
	}
});

bxsAPI.apis.push({
	cid : 8,
	name : "余额充值记录",
	url: "/api/v1/pays/rechargerecord",
	method : "GET",
	auth:"商户",
	ispage:true,
	desc : "余额充值记录列表",
	returns : {
		list : "记录列表",
		after_balance : "充值后的余额",
	}
});
bxsAPI.apis.push({
	cid : 8,
	name : "套餐列表",
	url: "/api/v1/valuepackages",
	method : "GET",
	auth:"商户",
	ispage:true,
	desc : "分页显示套餐列表",
	returns : {
		type:"套餐类型",
		watch_num_limit : "多少人每场",
		original_price:"原价格",
		price : "价格",
	}
});
bxsAPI.apis.push({
	cid : 8,
	name : "商户提现列表",
	url: "/api/v1/deposits",
	method : "GET",
	auth:"商户",
	ispage:true,
	desc : "分页显示商户提现列表。",
	returns : {
		"merchant_id": "商户ID",
		"money": "提现金额",
		"type": "提现方式，1：微信；2：支付宝",
		"cash_account": "提现到账号",
		"status": "提现状态",
		"audit_time": "审核时间",
	}
});
bxsAPI.apis.push({
	cid : 8,
	name : "商户提现详情",
	url: "/api/v1/deposits",
	method : "GET",
	ispage:true,
	auth:"商户",
	desc : "商户提现详情。",
	returns : {
		"merchant_id": "商户ID",
		"money": "提现金额",
		"type": "提现方式，1：微信；2：支付宝",
		"cash_account": "提现到账号",
		"status": "提现状态",
		"audit_time": "审核时间",
	}
});
//------------------------------end-------------cid8----------------------------------------------
bxsAPI.apis.push({
	cid : 9,
	name : "IM签名",
	url: "/api/v1/consumer/imsig",
	method : "POST",
	auth:"商户",
	body:"<redlight>[from-data]</redlight>TEXT",
	params : [
		{field:"account",isrequire:true,desc:"聊天成员账号",sample:"23423sdd"},
	],
	desc : "腾讯IM聊天室SDK聊天成员账号签名。",
	returns : {
		account : "签名的账号",
		sdkAppID : "SDKID",
		imsig : "签名",
	}
});
bxsAPI.apis.push({
	cid : 9,
	name : "文件上传阿里云OSS签名",
	url: "/api/v1/aliyuns/oss",
	method : "GET",
	auth:"商户",
	ispage:true,
	desc : "获取商户的直播间列表",
	returns : {
		host : "图片上传阿里云服务器地址",
		signature : "签名",
		callback : "回调服务器地址",
	}
});
bxsAPI.apis.push({
	cid : 9,
	name : "腾讯云视频上传UGC签名",
	url: "/api/v1/deal/ugcsign",
	method : "GET",
	auth:"商户",
	urlparams : [
		{field:"f",isrequire:true,desc:"视频文件本地名称，长度在40个字节以内，不得包含 / : * ? \" < > 等字符",sample:"kankan"},
		{field:"ft",isrequire:true,desc:"文件类型，例如mp4,flv,avi等，注意不需要\".\"",sample:"mp4"},
		{field:"fs",isrequire:true,desc:"文件的SHA-1签名，由客户端计算并提交到APP后台",sample:"1"},
	],
	desc : "腾讯云视频上传UGC签名",
	returns : {
		signature : "签名",
	}
});
bxsAPI.apis.push({
	cid : 9,
	name : "微信JSSDK签名",
	url: "/api/v1/signature/we-chat-jssdk",
	method : "POST",
	auth:"商户",
	params : [
		{field:"current_url",isrequire:true,desc:"当前网页的URL，不包含#及其后面部分。注意：对于没有只有域名没有 path 的 URL ，浏览器会自动加上 / 作为 path，如打开 http://qq.com 则获取到的 URL 为 http://qq.com/",sample:"http://qq.com/"},
	],
	desc : "微信签名",
	returns : {
		"appId": "微信公众号APPID",
		"nonceStr": "随机字符串",
		"timestamp": "时间戳",
		"url": "当前地址",
		"signature": "签名",
		"rawString": "被签名的参数"
	}
});
//------------------------------end-------------cid9----------------------------------------------
//------------------------------end-------------cid10---------------------------------------------
