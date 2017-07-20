<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:69:"D:\xampp\htdocs\ota\public/../application/admin\view\house\index.html";i:1500099444;s:64:"D:\xampp\htdocs\ota\public/../application/admin\view\layout.html";i:1500091511;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>琼中OTA后台管理</title>
    <link rel="stylesheet" href="/static/css/app.css?ver=<?php echo time(); ?>">
    <link href="/static/css/component.css" rel="stylesheet">
    <link href="/DatePicker/css/datepicker.css" rel="stylesheet"/>

    <script src="/static/js/jquery-3.2.1.min.js"></script>
</head>

<body>

<div class="head" id="header">
    <div class="head_box">
        <div class="inner wrp">
            <h1 class="logo">
                <a href="https://mp.weixin.qq.com/" title="微信公众平台"></a>
            </h1>
            <div class="account">
                <div class="account_meta account_info account_meta_primary">
                    <a href="#" class="nickname">
                        <?php switch($role): case "1": ?>系统管理员：<?php break; case "2": ?>民宿店家：<?php break; case "3": ?>书童：<?php break; default: ?>管理员：
                        <?php endswitch; ?>
                        <span style="color: #00AA00"><?php echo $admin['name']; ?></span>
                    </a>
                    <span class="type_wrp"></span>
                </div>
                <div class="account_meta account_logout account_meta_primary"><a id="logout" href="/admin/user/logout">退出</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="body" class="body page_user">
    <div id="js_container_box" class="container_box cell_layout side_l">
        <div class="col_side">
            <div class="menu_box" id="menuBar">
                <?php if(is_array($menu) || $menu instanceof \think\Collection || $menu instanceof \think\Paginator): $k = 0; $__LIST__ = $menu;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$x): $mod = ($k % 2 );++$k;if(in_array(($role), is_array($x['auth_role'])?$x['auth_role']:explode(',',$x['auth_role']))): ?>
                <dl class="menu <?php if($k==1): ?> no_extra<?php endif; ?>">
                    <dt class="menu_title">
                        <i class="icon_menu" style="background:url(<?php echo $x['icon']; ?>) no-repeat;"></i>
                        <?php echo $x['name']; ?>
                    </dt>
                    <?php if(is_array($x['item']) || $x['item'] instanceof \think\Collection || $x['item'] instanceof \think\Paginator): $i = 0; $__LIST__ = $x['item'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$y): $mod = ($i % 2 );++$i;if(in_array(($role), is_array($y['auth_role'])?$y['auth_role']:explode(',',$y['auth_role']))): ?>
                    <dd class="menu_item "><a href="<?php echo $y['url']; ?>"><?php echo $y['name']; ?></a></dd>
                    <?php endif; endforeach; endif; else: echo "" ;endif; ?>
                </dl>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </div>

        </div>
        <div class="col_main">
            <style type="text/css">
    *{margin:0;padding:0px;}
    .calendar_btn{margin-top:10px;padding:0px 5px;height:30px;line-height:30px;border-radius:3px;border:1px solid #ccc;cursor:pointer;text-align:center;}
</style>
<script>
    function AjaxTime(houseId){
        $.get("/api/room_price_calendar?house_id="+houseId,function(data) {
            if(data.code==100){
                pickerEvent.setPriceArr(data.data);
            }
            pickerEvent.Init(houseId,houseId,"calendar_"+houseId,1);
        });
    }
</script>

<div class="main_hd">
    <h2>民宿客栈</h2>
    <div class="title_tab">
        <ul class="tab_navs title_tab">
            <li class="tab_nav first js_top selected"><a href="javascript:void(0);">全部民宿</a></li>
            <li class="tab_nav first js_top"><a href="javascript:void(0);">营业中</a></li>
            <li class="tab_nav first js_top"><a href="javascript:void(0);">最受欢迎</a></li>
        </ul>
    </div>
</div>
<div class="main_bd">
    <a class="btn btn_primary" href="/admin/house/create">新增</a>

    <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$hotel): $mod = ($i % 2 );++$i;?>
    <div class="list_item">

        <div class="left">
             <img src="<?php echo $hotel['thumb']; ?>" />
        </div>
        <div class="left" style="margin-left: 20px">
            <h4><?php echo $hotel['name']; ?></h4>
            <div style="position: absolute;">
                <?php switch($hotel['status']): case "1": ?><label style="color: green;margin-left: 450px">正在营业中...</label><?php break; default: ?><label style="color: red;margin-left: 450px">已暂停营业</label>
                <?php endswitch; ?>
            </div>
            <div style="margin-top: 5px">
                <input id="calendar_<?php echo $hotel['id']; ?>" style="width: 124px" location="right" class="calendar_btn" name="calendar" readonly="readonly" onclick="AjaxTime('<?php echo $hotel['id']; ?>');" placeholder="整套价格日历"/>
            </div>
            <div style="margin-top: 10px">
                <a class="btn btn_primary" style="width: 90px" href="/admin/room?house_id=<?php echo $hotel['id']; ?>">房间管理</a>
            </div>
            <div style="margin-top: 10px">
                <a class="btn btn_primary" style="width: 90px" href="/admin/house/edit/id/<?php echo $hotel['id']; ?>">修改民宿</a>
            </div>
            <div style="margin-top: 10px">
                <?php switch($hotel['status']): case "1": ?><a class="btn btn_primary" style="width: 90px" href='javascript:toggle("<?php echo $hotel['id']; ?>","<?php echo $hotel['status']; ?>")'>停止营业</a><?php break; default: ?><a class="btn" style="width: 90px" href='javascript:toggle("<?php echo $hotel['id']; ?>","<?php echo $hotel['status']; ?>")'>开启营业</a>
                <?php endswitch; ?>

            </div>
        </div>
    </div>
    <?php endforeach; endif; else: echo "" ;endif; ?>
    <div class="page"><?php echo $list->render(); ?></div>
</div>
<script>
    function toggle(id,sta) {
        var ac = "";
        if(sta == 1){
            ac = "停止";
            sta = -1;
        }else {
            ac = "开启";
            sta = 1;
        }
        if(confirm("你确认"+ac+"营业么？")){

            $.post('/admin/house/toggle/id/'+id,{status:sta},function (data,status) {
                if(data['code']==100){
                    window.location = "";
                }else {
                    alert("操作失败："+data['msg'])
                }
            })
        }
    }
</script>

        </div>
    </div>
    <div class="faq">
        <ul class="links">
            <li class="links_item"><a href="http://kf.qq.com/faq/120911VrYVrA1509086vyumm.html" target="_blank">客服中心</a>
            </li>
            <li class="links_item"><a
                    href="https://mp.weixin.qq.com/acct/infringement?action=getmanual&amp;t=infringement/manual&amp;type=1&amp;lang=zh_CN&amp;token=204132418"
                    target="_blank">侵权投诉</a></li>
        </ul>
        <p class="tail">反馈官号weixingongzhong</p>
    </div>
</div>


<div class="foot" id="footer">
    <ul class="links ft">
        <li class="links_item no_extra"><a href="#" target="_blank">关于我们</a></li>
        <li class="links_item"><a href="#" target="_blank">客服中心</a></li>
        <li class="links_item"><a href="#" target="_blank">联系邮箱</a></li>
        <li class="links_item">
            <p class="copyright">Copyright © 2015-2017 海口云宿乡土网络科技有限公司. All Rights Reserved.</p>
        </li>
    </ul>
</div>
<script>
    window.onload = function () {

        var menuList = document.querySelectorAll('.menu_item');
        var index = Number(sessionStorage.getItem('js-active-menu'));

        if (index > -1 && index < menuList.length) {
            console.log(index);
            menuList[index].className += ' selected'
        }

        for (var i = 0; i < menuList.length; i++) {

            menuList[i].addEventListener("click", function (k) {

                return function () {

                    sessionStorage.setItem('js-active-menu', k);
                    document.querySelector('.selected').className = document.querySelector('.selected').className.replace(/selected/, '');
                    this.className += ' selected';
                    console.log(sessionStorage)
                }
            }(i))

        }

    }

</script>
</body>

<script src="/static/js/jquery.easing.min.js" type="text/javascript"></script>
<script src="/DatePicker/js/zlDate.js"></script>
<script src="/static/js/classie.js"></script>
<script src="/static/js/modalEffects.js"></script>
<script src="/static/js/zzsc.js" type="text/javascript"></script>
</html>
