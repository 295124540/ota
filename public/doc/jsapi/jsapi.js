/**
 * API接口定义 服务器，接口方法，接口参数及说明，测试数据，
 */
var bxsAPI = {};
bxsAPI.local = location.toString().indexOf("http://127.0.0.1") > -1 ? 0 : 1;
bxsAPI.apis = [];
bxsAPI.server = bxsAPI.local?"http://saas.icloudinn.com":"http://saas.com";
bxsAPI.uid = bxsAPI.local?"22497":"22497";
bxsAPI.un = "13552997366";
bxsAPI.userToken = "6d7a2e40-4949-4c89-b00b-58a38626ae91";
bxsAPI.ziruo = "false";
bxsAPI.readme = "云商直播（saaslive），本系统采用Yii2框架编写，API接口严格遵循RESTful Web API风格。<br> " +
		"本系统ID是<redlight>10</redlight>，该系统ID会在商城系统授权认证时用到。<br>" +
		"接口授权认证，access token 当作API URL请求参数发送，例如<redlight> https://example.com/users?access-token=xxxxxxxx。</redlight>";

// API最新版本号，更新需要调整版本号，并更新下面的记录
bxsAPI.version = "v1.0";
bxsAPI.updated = [ {
	ver : "v1.0",
	dt : "2016-11-01",
	con : [ "全部接口", ]
}, {
	ver : "v2.0",
	dt : "待定.....",
	con : [ "<a href='#/product_consultalist'></a>房间列表接口重新定义 。</br>", ]
}, ];

/**
 * 接口模块定义 主要用于分类接口，看起来更清楚
 */

bxsAPI.apicates = [// api模块
 {
	cid : 1,
	name : "公共"
},
{
	cid : 2,
	name : "首页"
}, 
{
	cid : 3,
	name : "商户"
},
{
	cid : 4,
	name : "直播"
},
{
	cid : 5,
	name : "商品"
},
{
	cid : 6,
	name : "素材"
},
{
	cid : 7,
	name : "礼物"
},
{
	cid : 8,
	name : "充值"
}
];


//------------------------------end-------------cid1----------------------------------------------
bxsAPI.apis.push({
	"anchor": "/Server/room/findGiftList",
	"desc": "查询礼物列表",
	"test": "",
	"name": "查询礼物列表",
	"method": "/Server/room/findGiftList",
	"params": {
	},
	"returns": {
		"data": "返回的数据",
		"code": "状态值",
		"msg": "提示",
	},
	"cid": 6,
});
//------------------------------end-------------cid2----------------------------------------------
//------------------------------end-------------cid3----------------------------------------------
//------------------------------end-------------cid4----------------------------------------------

bxsAPI.apis.push({
	anchor : "/Server/room/registRoomInfo",
	name : "商品列表",
	method : "http://shop.icloudinn.com/index.php/Api/Goods/merchantGoodsList?access-token=oVhZgg4Skvks9dsCA3iKVbivqsONiUCVrxN6q4Ye&system_id=10",
	cid : 5,
	params : {
		title : "<require>[必选]</require>房间标题",
		coverImgUrl : "<require>[必选]</require>封面图片",
		roomCode : "<require>[必选]</require>房间号码",
		chatRoomId : "<require>[必选]</require>聊天房间号",
		avRoomId : "<require>[必选]</require>视频房间号",
		userId : "<require>[必选]</require>主播id",
		fileName : "<require>[必选]</require>视频名字",
		address : "<require>[必选]</require>地址",
		themeId : "<require>[必选]</require>主题id",
	},
	desc : "登记房间信息",
	test : "&title=朵朵" +
	"&coverImgUrl=http://yycollege.yueyee.cc/file_upload/advert/201607/20160708/20160708141602500.jpg" +
	"&roomCode=1232323243&chatRoomId=1232323243" +
	"&avRoomId=1232323243" +
	"&userId=4028fc9b55f28dd10155f2933b6e0001" +
	"&fileName=2016_07_25_10_53_33_70916" +
	"&address=海南省美兰市" +
	"&themeId=1",
	returns : {
		code : "状态值",
		msg : "提示",
		data : "返回的数据 数据列表",
	}
});

bxsAPI.apis.push({
	anchor : "/Server/room/registRoomInfo",
	name : "商品详情",
	method : "/Server/room/registRoomInfo",
	cid : 5,
	params : {
		title : "<require>[必选]</require>房间标题",
		coverImgUrl : "<require>[必选]</require>封面图片",
		roomCode : "<require>[必选]</require>房间号码",
		chatRoomId : "<require>[必选]</require>聊天房间号",
		avRoomId : "<require>[必选]</require>视频房间号",
		userId : "<require>[必选]</require>主播id",
		fileName : "<require>[必选]</require>视频名字",
		address : "<require>[必选]</require>地址",
		themeId : "<require>[必选]</require>主题id",
	},
	desc : "登记房间信息",
	test : "&title=朵朵" +
	"&coverImgUrl=http://yycollege.yueyee.cc/file_upload/advert/201607/20160708/20160708141602500.jpg" +
	"&roomCode=1232323243&chatRoomId=1232323243" +
	"&avRoomId=1232323243" +
	"&userId=4028fc9b55f28dd10155f2933b6e0001" +
	"&fileName=2016_07_25_10_53_33_70916" +
	"&address=海南省美兰市" +
	"&themeId=1",
	returns : {
		code : "状态值",
		msg : "提示",
		data : "返回的数据 数据列表",
	}
});

bxsAPI.apis.push({
	anchor : "/Server/room/registRoomInfo",
	name : "新增商品",
	method : "/Server/room/registRoomInfo",
	cid : 5,
	params : {
		title : "<require>[必选]</require>房间标题",
		coverImgUrl : "<require>[必选]</require>封面图片",
		roomCode : "<require>[必选]</require>房间号码",
		chatRoomId : "<require>[必选]</require>聊天房间号",
		avRoomId : "<require>[必选]</require>视频房间号",
		userId : "<require>[必选]</require>主播id",
		fileName : "<require>[必选]</require>视频名字",
		address : "<require>[必选]</require>地址",
		themeId : "<require>[必选]</require>主题id",
	},
	desc : "登记房间信息",
	test : "&title=朵朵" +
	"&coverImgUrl=http://yycollege.yueyee.cc/file_upload/advert/201607/20160708/20160708141602500.jpg" +
	"&roomCode=1232323243&chatRoomId=1232323243" +
	"&avRoomId=1232323243" +
	"&userId=4028fc9b55f28dd10155f2933b6e0001" +
	"&fileName=2016_07_25_10_53_33_70916" +
	"&address=海南省美兰市" +
	"&themeId=1",
	returns : {
		code : "状态值",
		msg : "提示",
		data : "返回的数据 数据列表",
	}
});

bxsAPI.apis.push({
	anchor : "/Server/room/registRoomInfo",
	name : "修改商品",
	method : "/Server/room/registRoomInfo",
	cid : 5,
	params : {
		title : "<require>[必选]</require>房间标题",
		coverImgUrl : "<require>[必选]</require>封面图片",
		roomCode : "<require>[必选]</require>房间号码",
		chatRoomId : "<require>[必选]</require>聊天房间号",
		avRoomId : "<require>[必选]</require>视频房间号",
		userId : "<require>[必选]</require>主播id",
		fileName : "<require>[必选]</require>视频名字",
		address : "<require>[必选]</require>地址",
		themeId : "<require>[必选]</require>主题id",
	},
	desc : "登记房间信息",
	test : "&title=朵朵" +
	"&coverImgUrl=http://yycollege.yueyee.cc/file_upload/advert/201607/20160708/20160708141602500.jpg" +
	"&roomCode=1232323243&chatRoomId=1232323243" +
	"&avRoomId=1232323243" +
	"&userId=4028fc9b55f28dd10155f2933b6e0001" +
	"&fileName=2016_07_25_10_53_33_70916" +
	"&address=海南省美兰市" +
	"&themeId=1",
	returns : {
		code : "状态值",
		msg : "提示",
		data : "返回的数据 数据列表",
	}
});

bxsAPI.apis.push({
	anchor : "/Server/room/registRoomInfo",
	name : "删除商品",
	method : "/Server/room/registRoomInfo",
	cid : 5,
	params : {
		title : "<require>[必选]</require>房间标题",
		coverImgUrl : "<require>[必选]</require>封面图片",
		roomCode : "<require>[必选]</require>房间号码",
		chatRoomId : "<require>[必选]</require>聊天房间号",
		avRoomId : "<require>[必选]</require>视频房间号",
		userId : "<require>[必选]</require>主播id",
		fileName : "<require>[必选]</require>视频名字",
		address : "<require>[必选]</require>地址",
		themeId : "<require>[必选]</require>主题id",
	},
	desc : "登记房间信息",
	test : "&title=朵朵" +
	"&coverImgUrl=http://yycollege.yueyee.cc/file_upload/advert/201607/20160708/20160708141602500.jpg" +
	"&roomCode=1232323243&chatRoomId=1232323243" +
	"&avRoomId=1232323243" +
	"&userId=4028fc9b55f28dd10155f2933b6e0001" +
	"&fileName=2016_07_25_10_53_33_70916" +
	"&address=海南省美兰市" +
	"&themeId=1",
	returns : {
		code : "状态值",
		msg : "提示",
		data : "返回的数据 数据列表",
	}
});
//------------------------------end-------------cid5----------------------------------------------
//------------------------------end-------------cid6----------------------------------------------
//------------------------------end-------------cid7----------------------------------------------
//------------------------------end-------------cid8----------------------------------------------
//------------------------------end-------------cid9----------------------------------------------
//------------------------------end-------------cid10---------------------------------------------
