<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"D:\xampp\htdocs\ota\public/../application/admin\view\room\index.html";i:1496733263;s:64:"D:\xampp\htdocs\ota\public/../application/admin\view\layout.html";i:1496741483;}*/ ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>琼中OTA后台管理</title>
    <link rel="stylesheet" href="/static/css/app.css?ver=<?php echo time(); ?>">
    <link href="/static/css/component.css" rel="stylesheet">
    <link href="/DatePicker/css/datepicker.css" rel="stylesheet" />

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
                        <a href="#" class="nickname">管理员</a> <span class="type_wrp"></span>
                    </div>
                    <div class="account_meta account_logout account_meta_primary"><a id="logout" href="/admin/user/logout">退出</a></div>
                </div>
            </div>
        </div>
    </div>

    <div id="body" class="body page_user">
        <div id="js_container_box" class="container_box cell_layout side_l">
            <div class="col_side">
                <div class="menu_box" id="menuBar">
                    <dl class="menu no_extra">
                        <dt class="menu_title"> 
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_function.png) no-repeat;"></i>
                            基础信息
                        </dt>
                        <dd class="menu_item "><a  href="/admin/index">首页</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title"> 
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_ad.png) no-repeat;"></i>
                            旅游服务
                        </dt>
                        <dd class="menu_item "><a  href="/admin/house">民宿客栈</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title">
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_statistics.png) no-repeat;"></i>
                            文化公益
                        </dt>
                        <dd class="menu_item "><a href="/admin/book_house">书屋管理</a></dd>
                        <dd class="menu_item "><a href="/admin/user/child">书童管理</a></dd>
                        <dd class="menu_item "><a href="/admin/book">书库管理</a></dd>
                        <dd class="menu_item "><a href="/admin/book_donate">捐书管理</a></dd>
                        <dd class="menu_item "><a href="/admin/book_rent">租书记录</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title">
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_ad.png) no-repeat;"></i>
                            智能硬件
                        </dt>
                        <dd class="menu_item "><a  href="/admin/house/getList">智能门锁</a></dd>
                        <dd class="menu_item "><a  href="/admin/house/lock">二维码打印机</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title"> 
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_management.png) no-repeat;"></i>
                            订单管理
                        </dt>
                         <dd class="menu_item"><a href="#">订单列表</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title">
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_setup.png) no-repeat;"></i>
                            数据统计
                        </dt>
                        <dd class="menu_item "><a href="#">用户统计</a></dd>
                        <dd class="menu_item "><a href="#">访问统计</a></dd>
                        <dd class="menu_item "><a href="#">交易记录</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title">
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_setup.png) no-repeat;"></i>
                            系统管理
                        </dt>
                        <dd class="menu_item "><a href="/admin/user/getList">运营管理者</a></dd>
                        <dd class="menu_item "><a href="#">数据库</a></dd>
                        <dd class="menu_item "><a href="#">系统缓存</a></dd>
                    </dl>

                    <dl class="menu ">
                        <dt class="menu_title"> 
                            <i class="icon_menu" style="background:url(/static/img/icon_menu_developer.png) no-repeat;">    </i>
                            投诉咨询
                        </dt>
                        <dd class="menu_item "><a href="#">游客咨询</a></dd>
                        <dd class="menu_item "><a href="#">投诉建议</a></dd>
                    </dl>
                </div>
                
            </div>
            <div class="col_main">
                <style type="text/css">
    *{margin:0;padding:0px;}
    .calendar_btn{margin-top:100px;padding:0px 5px;width:250px;height:30px;line-height:30px;border-radius:3px;border:1px solid #ccc;cursor:pointer;text-align:center;}
</style>
<script>
    function AjaxTime(houseId,roomId){
        $.get("/api/room_price_calendar?house_id="+houseId+"&room_id="+roomId,function(data) {
            if(data.code==100){
                pickerEvent.setPriceArr(data.data);
            }
            pickerEvent.Init(houseId,roomId,"calendar_"+roomId,0);
        });
    }
</script>
<div class="main_hd">
    <h2>客栈套间</h2>
    <div class="title_tab">
        <ul class="tab_navs title_tab">
            <li class="tab_nav first js_top"><a href="/admin/house">全部民宿</a></li>
            <li class="tab_nav first js_top"><a href="javascript:void(0);">营业中</a></li>
            <li class="tab_nav first js_top"><a href="javascript:void(0);">最受欢迎</a></li>
            <li class="tab_nav first js_top selected"><a href="javascript:void(0);">套间管理</a></li>
        </ul>
    </div>
</div>
<div class="main_bd">
    <a class="btn btn_primary" href="/admin/room/create?house_id=<?php echo $houseId; ?>">添加套间</a>
    <table class="goods_list hotel_list">
        <tbody><tr>
            <th>套间ID</th>
            <th>套间名称</th>
            <th>套间主题</th>
            <th>平时价格（元）</th>
            <th>操作</th>
        </tr>
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$model): $mod = ($i % 2 );++$i;?>
        <tr>
            <td>202</td>
            <td class="name"><?php echo $model['name']; ?></td>
            <td><?php echo $model['theme']; ?></td>
            <td><?php echo $model['price']; ?></td>
            <td>
                <input id="calendar_<?php echo $model['id']; ?>" class="calendar_btn" name="calendar" readonly="readonly" onclick="AjaxTime('<?php echo $houseId; ?>','<?php echo $model['id']; ?>');" placeholder="价格日历"/>
                <!--<a href="javascript:;" class="md-trigger btn btn-primary btn-sm" data-modal="modal-1">价格日历</a> -->
                <a class="btn btn_primary" href="/admin/room/edit/id/<?php echo $model['id']; ?>?house_id=<?php echo $houseId; ?>">编辑</a>
                <a class="btn btn_primary" href="/admin/room/delete/id/<?php echo $model['id']; ?>?house_id=<?php echo $houseId; ?>">删除</a>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
    </table>

    <div class="md-modal md-effect-1" id="modal-1">
        <div class="md-content">
            <h3>Modal Dialog</h3>
            <div>
                <p>This is a modal window. You can do the following things with it:</p>
                <ul>
                    <li><strong>Read:</strong> modal windows will probably tell you something important so don't forget to read what they say.</li>
                    <li><strong>Look:</strong> a modal window enjoys a certain kind of attention; just look at it and appreciate its presence.</li>
                    <li><strong>Close:</strong> click on the button below to close the modal.</li>
                </ul>
                <button class="md-close btn-sm btn-primary">Close me!</button>
            </div>
        </div>
    </div>
    <div class="md-overlay"></div>
</div>

            </div>
        </div>
        <div class="faq">
            <ul class="links">
                <li class="links_item"><a href="http://kf.qq.com/faq/120911VrYVrA1509086vyumm.html" target="_blank">客服中心</a></li>
                <li class="links_item"><a href="https://mp.weixin.qq.com/acct/infringement?action=getmanual&amp;t=infringement/manual&amp;type=1&amp;lang=zh_CN&amp;token=204132418"
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
        window.onload = function(){

            var menuList = document.querySelectorAll('.menu_item');
            var index = Number(sessionStorage.getItem('js-active-menu'));

            if(index>-1 && index<menuList.length){
                console.log(index);
                menuList[index].className+=' selected'
            }

            for(var i=0;i<menuList.length;i++ ){

                menuList[i].addEventListener("click",function(k){

                    return function(){

                        sessionStorage.setItem('js-active-menu',k);
                        document.querySelector('.selected').className = document.querySelector('.selected').className.replace(/selected/,'');
                        this.className+=' selected';
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
