/**
 *
 */
var bxsAPI = {};
bxsAPI.progress=[];
bxsAPI.standard="琼中OTA--微信小程序、管理后台";
bxsAPI.group=[
    {groupName:"产品设计",detail:"汪君相、梁绣"},
    {groupName:"UI设计",detail:"李瑞龙"},
    {groupName:"后端开发",detail:"陈万洲"},
    {groupName:"小程序开发",detail:"汪君相、李转清"},
	{groupName:"IOS开发",detail:"唐晓斌"},
	{groupName:"安卓开发",detail:"李俊宇"},
];
bxsAPI.mainFunctions=[
	"民宿预订",
	"书籍捐、借、著",
	"社区",
];

bxsAPI.progress.push({
	week : "一",
	date:"5.15-5.19",
	model: [
		{
			modelName:"搭架子",
			functions:[
				"系统架构",
				"数据库设计",
				"运行环境",
				"后台设计",
			]
		},
		{
			modelName:"用户模块",
			functions:[
				"小程序登录",
			]
		},
		{
			modelName:"民宿模块",
			functions:[
				"民宿列表",
				"民宿详情"
			]
		}
	]
});

bxsAPI.progress.push({
	week : "二",
	date:"5.22-5.27",
	model: [
		{
			modelName:"书屋后台菜单",
			functions:[
				"书屋管理",
				"书童管理",
				"书库管理",
				"捐书管理",
				"租书管理",
			]
		},
		{
			modelName:"收藏",
			functions:[
				"收藏\\取消收藏",
				"收藏列表",
				"收藏详情",
			]
		}
	]
});

bxsAPI.progress.push({
	week : "三",
	date:"5.31-6.2",
	model: [
		{
			modelName:"订单",
			functions:[
				"民宿、书本下单",
				"订单列表",
				"订单状态",
			]
		},
		{
			modelName:"支付",
			functions:[
				"签名",
				"通知",
			]
		},
		{
			modelName:"后台",
			functions:[
				"房间管理",
				"其他优化",
			]
		}
	]
});

bxsAPI.progress.push({
	week : "四",
	date:"6.5-6.9",
	model: [
		{
			modelName:"单间、整套预订",
			functions:[
				"后台套间增删改查",
				"套间预订接口",
			]
		},
		{
			modelName:"价格日历",
			functions:[
				"后台日历价格设置",
				"价格日历接口",
			]
		},
		{
			modelName:"民宿配套设施",
			functions:[
				"后台配套设施管理",
				"完善民宿配套设施接口",
			]
		}
	]
});

bxsAPI.progress.push({
	week : "五",
	date:"6.12-6.16",
	model: [
		{
			modelName:"个人中心",
			functions:[
				"短信验证",
				"绑定手机号",
				"积分增减",
			]
		},
		{
			modelName:"后台订单",
			functions:[
				"订单管理",
			]
		},
		{
			modelName:"圈子动态",
			functions:[
				"动态列表",
				"发布圈子动态",
				"图片上传"
			]
		},
		{
			modelName:"圈子名片",
			functions:[
				"TA的详情",
				"关注TA",
				"TA的捐书",
				"TA的租书",
			]
		},
		{
			modelName:"著书",
			functions:[
				"著书后台发布",
				"著书后台更新",
				"著书接口",
			]
		},
	]
});

bxsAPI.progress.push({
	week : "六",
	date:"6.19-6.23",
	model: [
		{
			modelName:"圈子动态",
			functions:[
				"动态评论",
				"评论回复",
			]
		},
		{
			modelName:"一本书",
			functions:[
				"书虫",
				"我的书",
				"全部分类书籍"
			]
		},
		{
			modelName:"关注",
			functions:[
				"我的关注",
				"关注我的",
			]
		},
		{
			modelName:"优化重构",
			functions:[
				"登录",
				"取消订单",
				"其他接口的优化"
			]
		},
	]
});

bxsAPI.progress.push({
	week : "七",
	date:"6.26-6.30",
	model: [
		{
			modelName:"优化",
			functions:[
				"调整了架构，加入了API版本控制",
				"动态评论",
				"评论回复",
			]
		},
		{
			modelName:"用户模块",
			functions:[
				"用户列表",
				"是否关注",
			]
		},
		{
			modelName:"书评模块",
			functions:[
				"回复",
			]
		},
		{
			modelName:"著书模块",
			functions:[
				"著书最新章节",
				"著书章节管理后台",
			]
		},
		{
			modelName:"价格日历",
			functions:[
				"已预订的名宿",
			]
		},
	]
});

bxsAPI.progress.push({
	week : "八",
	date:"7.3-7.7",
	model: [
		{
			modelName:"优化",
			functions:[
				"修复了关注我列表用户信息异常",
				"完善了后台著书编辑管理功能",
				"修改后台大部分UI",
				"修复了退房申请、退房审核、民宿评论时订单状态改变",
				"修复了后台民宿营业开关管理",

			]
		},
		{
			modelName:"错误日志",
			functions:[
				"接口错误日志",
				"系统错误日志",
				"后台日志查看"
			]
		},
		{
			modelName:"积分系统",
			functions:[
				"积分获取规则",
				"租书获得积分",
				"捐书审核通过获得积分",
				"书评获得积分",
			]
		},
	]
});

bxsAPI.progress.push({
	week : "九",
	date:"7.10-7.15",
	model: [
		{
			modelName:"优化",
			functions:[
				"修复了部分接口异常",
				"更换了小程序账号",
			]
		},
		{
			modelName:"私聊",
			functions:[
				"接入了腾讯IM",
				"IM签名",
				"腾讯云独立模式用户导入"
			]
		},
		{
			modelName:"相册",
			functions:[
				"我的相册",
				"他的相册",
				"接入了阿里云OSS对象存储"
			]
		},
		{
			modelName:"后台权限",
			functions:[
				"我是系统管理员",
				"我是书童",
				"我是商家",
				"完善了登录角色验证"
			]
		},
	]
});


bxsAPI.progress.push({
	week : "十",
	date:"7.17-7.21",
	model: [
		{
			modelName:"优化",
			functions:[
				"优化了token校验规则",
				"修复了评论书宿，不能生成动态问题",
				"优化了圈子动态",
				"优化了民宿订单提示",
				"废弃了民宿下单接口，新添加了民宿下单接口",
				"重构了民宿订单",
				"调整了微信支付回调通知",
				"调整了用户系统微信登录，unionId作为身份关键字段，弃用openId"
			]
		}
	]
});
bxsAPI.progress.push({
	week : "十一",
	date:"7.17-7.21",
	model: [
		{
			modelName:"优化",
			functions:[
				"更换了小程序账号",
				"重构了支付成功回调通知",
				"优化了圈子动态",
				"租书定金支付流程更换",
			]
		}
	]
});


