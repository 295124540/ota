<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:67:"D:\xampp\htdocs\ota\public/../application/admin\view\room\edit.html";i:1496818267;s:64:"D:\xampp\htdocs\ota\public/../application/admin\view\layout.html";i:1496741483;}*/ ?>
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
                <div class="main_hd">
    <h2>套间信息修改</h2>
    <div class="title_tab">
        <ul class="tab_navs title_tab">
            <li class="tab_nav first js_top"><a href="/admin/house">全部民宿</a></li>
            <li class="tab_nav first js_top"><a href="javascript:void(0);">营业中</a></li>
            <li class="tab_nav first js_top"><a href="javascript:void(0);">最受欢迎</a></li>
            <li class="tab_nav first js_top"><a href="javascript:history.back();">套间管理</a></li>
            <li class="tab_nav first js_top selected"><a href="javascript:void(0);">信息修改</a></li>
        </ul>
    </div>
</div>
<div class="main_bd">

    <form action="/admin/room/update/id/<?php echo $model['id']; ?>?house_id=<?php echo $houseId; ?>" enctype="multipart/form-data" method="post" class=" form goods_form goods_add_form">
        <div class="form_group">
            <label>套间主题</label>
            <select name="theme">
                <?php if(is_array($typeList) || $typeList instanceof \think\Collection || $typeList instanceof \think\Paginator): $i = 0; $__LIST__ = $typeList;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$type): $mod = ($i % 2 );++$i;if($type['id']==1): ?>
                 <option selected value="<?php echo $type['name']; ?>"><?php echo $type['name']; ?></option>
                 <?php else: ?>
                 <option value="<?php echo $type['name']; ?>"><?php echo $type['name']; ?></option>
                <?php endif; endforeach; endif; else: echo "" ;endif; ?>
            </select>

        </div>
        <div class="form_group">
            <label>套间名称</label><input  name="name" value="<?php echo $model['name']; ?>" type="text" maxlength="15" />
        </div>
        <div class="form_group">
            <label>床位</label><input  name="bed"  value="<?php echo $model['bed']; ?>" type="text" maxlength="20" />
        </div>
        <div class="form_group">
            <label>平时价格</label><input  name="price" value="<?php echo $model['price']; ?>" maxlength="5"   />
        </div>
        <div class="form_group">
            <label>可住人数</label><input  name="accept_num" value="<?php echo $model['accept_num']; ?>" maxlength="2"  />
        </div>

        <div class="form_group">
            <label>套间图片</label>
            <div class="upload_img_box">
                <?php if(is_array($model['img']) || $model['img'] instanceof \think\Collection || $model['img'] instanceof \think\Paginator): $i = 0; $__LIST__ = $model['img'];if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$img): $mod = ($i % 2 );++$i;?>
                <div class="upload_img_label" >
                    <img class='thumb'  src="<?php echo $img['url']; ?>"/>
                    <?php if(in_array(($i), explode(',',"0"))): ?>
                    <div class="ismain">*主图</div>
                    <?php endif; ?>
                </div>
                <input class="upload_img_input" accept="image/jpeg,image/jpg,image/png" type="file" name="image[]" />
                <input type="hidden" name="imageId[]" value="<?php echo $img['id']; ?>" />
                <?php endforeach; endif; else: echo "" ;endif; $__FOR_START_18817__=$i;$__FOR_END_18817__=4;for($i=$__FOR_START_18817__;$i < $__FOR_END_18817__;$i+=1){ ?>
                <div class="upload_img_label" ></div>
                <input class="upload_img_input" accept="image/jpeg,image/jpg,image/png" type="file" name="image[]" id="pic_1" />
                <?php } ?>
            </div>

        </div>

                    
        <div class="goods_desc_box form_group">
            <label>套间介绍</label>
            <script class="ueditor" id="container" name="intro" value="<?php echo $model['intro']; ?>" type="text/plain">套间简要介绍说明！</script>
            <script type="text/javascript" src="/ueditor/ueditor.config.js"></script>
            <!-- 编辑器源码文件 -->
            <script type="text/javascript" src="/ueditor/ueditor.all.js"></script>
            <!-- 实例化编辑器 -->
            <script type="text/javascript">
                var ue = UE.getEditor('container',{
                    // initialFrameWidth:800,
                    // initialFrameHeight:300
                });
            </script>
        </div>

        <div class="current_box">
            <input type="button" onclick="submit()" name="next" class="next btn btn_primary " value="确认修改" />
        </div>

        <!--<button class="submit">修改</button>-->
    </form>
</div>


<script>




    $(function() {

        $(".upload_img_label").on('click',function(e){

            var index = $(".upload_img_label").index(this);
            $('.upload_img_input').eq(index).click();
        })

        $(".upload_img_input").on("change",function(){

            var objUrl = getObjectURL(this.files[0]) ; //获取图片的路径，该路径不是图片在本地的路径
            if (objUrl) {

                var index = $(".upload_img_input").index(this);

                var tempStr = "<img class='thumb'  />",
                $label = $(".upload_img_label").eq(index);

                $label.append(tempStr);
                console.log($label.find('img.thumb'));
                $label.find('img.thumb').attr('src',objUrl);

            }

        });
    });

    function getObjectURL(file) {
        var url = null ;
        if (window.createObjectURL!=undefined) { // basic
            url = window.createObjectURL(file) ;
        } else if (window.URL!=undefined) { // mozilla(firefox)
            url = window.URL.createObjectURL(file) ;
        } else if (window.webkitURL!=undefined) { // webkit or chrome
            url = window.webkitURL.createObjectURL(file) ;
        }
        return url ;
    }


    function submit(){
        // return false;
        document.form[0].submit();
    }
</script>
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
