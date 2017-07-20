<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:74:"D:\xampp\htdocs\ota\public/../application/admin\view\book_write\index.html";i:1498794920;s:64:"D:\xampp\htdocs\ota\public/../application/admin\view\layout.html";i:1500091511;}*/ ?>
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
            <div class="main_hd">
    <h2>著书</h2>
    <div class="title_tab">
        <ul class="tab_navs title_tab">
            <li class="tab_nav first js_top  selected"><a href="javascript:void(0);" id="reloadTop">全部著书</a></li>
            <li class="tab_nav js_top"><a href="/admin/book_write/create" id="blackTop">发布著书</a></li>
        </ul>
    </div>
</div>
<div class="main_bd">
    <table class="city_list">
        <tr>
            <td>编号</td>
            <td>封面</td>
            <td>书名</td>
            <td>作者</td>
            <td>最新章节</td>
            <td>发起时间</td>
            <td>更新时间</td>
            <td>操作</td>
        </tr>
        <?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$x): $mod = ($i % 2 );++$i;?>
        <tr>
            <td><?php echo $x['id']; ?></td>
            <td><img src="<?php echo $x['cover']; ?>" width="100px" height="150px"></td>
            <td><?php echo $x['name']; ?></td>
            <td><?php echo $x['author']; ?></td>
            <td>第<?php echo $x['new_chapter']['sequence']; ?>章：<?php echo $x['new_chapter']['content']; ?></td>
            <td><?php echo date('Y-m-d H:i',$x['create_time']); ?></td>
            <td><?php echo date('Y-m-d H:i',$x['new_chapter']['update_time']); ?></td>
            <td>
                <a class="btn btn_primary" href="/admin/book_write/edit?id=<?php echo $x['id']; ?>">更新</a>
                <a class="btn btn_primary" href="#">完成</a>
                <a class="btn btn_primary" href="/admin/book_write/delete/id/<?php echo $x['id']; ?>">删除</a>
            </td>
        </tr>
        <?php endforeach; endif; else: echo "" ;endif; ?>
    </table>
    <div class="page"><?php echo $list->render(); ?></div>

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
