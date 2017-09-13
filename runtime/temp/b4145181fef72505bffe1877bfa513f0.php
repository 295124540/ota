<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:71:"D:\xampp\htdocs\ota\public/../application/admin\view\user\addadmin.html";i:1500089124;s:64:"D:\xampp\htdocs\ota\public/../application/admin\view\layout.html";i:1500087413;}*/ ?>
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
                    <a href="#" class="nickname">管理员</a> <span class="type_wrp"></span>
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
            <div class="main_hd">
    <h2>运营管理者</h2>
    <div class="title_tab">
        <ul class="tab_navs title_tab">
            <li class="tab_nav first js_top"><a href="/admin/user/getList" id="reloadTop">人员列表</a></li>
            <li class="tab_nav js_top selected"><a href="javascript:void(0);" id="blackTop">添加管理者</a></li>
        </ul>
    </div>
</div>
<div class="main_bd">
    <form class="form" action="/admin/user/doAddAdmin" method="post">
        <div class="form_group">
            <label>管理角色</label>
            <select name="role">
                <option value="1">普通管理员</option>
                <option value="2">民宿店家</option>
                <option value="3">书童</option>
            </select>
        </div>
        <div class="form_group">
            <label>姓名</label>
            <input type="text" name="phone" maxlength="6" />
        </div>
        <div class="form_group">
            <label>电话</label>
            <input type="text" name="phone" maxlength="11" />
        </div>
        <div class="form_group">
            <label>邮箱</label>
            <input type="text" name="email"  />
        </div>
        <div class="form_group">
            <label>密码</label>
            <input type="password" name="password"  />
        </div>
        <button class="btn btn_primary">提交</button>
    </form>
</div>


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
