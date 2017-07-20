<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
$v = request()->header('version');
if($v==null) $v = "v1";
return [

    //api版本控制
    'api/:controller$'=>['api/'.$v.'.:controller/index',['method' => 'get']],
    'api/:controller/:id' => ['api/'.$v.'.:controller/read',['method' => 'get'], ['id' => '\d+']],
    'api/:controller/:function$'=>'api/'.$v.'.:controller/:function',

    // 全局变量规则定义
    '__pattern__' => [
        'name' => '\w+',
    ],

    //资源路由
    '__rest__'=>[
        //api
        'api/house'=>['api/'.$v.'.house',['only'=>['index','read','create','save','edit','update','delete']]],
        'api/book'=>['api/'.$v.'.book',['only'=>['index','read','create','save','edit','update','delete']]],
        'api/book_rent'=>['api/'.$v.'.book_rent',['only'=>['index','read','save']]],
        'api/book_donate'=>['api/'.$v.'.book_donate',['only'=>['index','read','save']]],
        'api/book_write'=>['api/'.$v.'.book_write',['only'=>['index','read']]],
        'api/collect'=>['api/'.$v.'.collect',['only'=>['index','read','save','delete']]],
        'api/comment'=>['api/'.$v.'.comment',['only'=>['index','read','save','delete']]],
        'api/order'=>['api/'.$v.'.order',['only'=>['index','read','save','update']]],
        'api/room_price_calendar'=>['api/'.$v.'.room_price_calendar',['only'=>['index','read','save','update']]],
        'api/cash_pledge'=>['api/'.$v.'.cash_pledge',['only'=>['index','read','save','update']]],
        'api/dynamic'=>['api/'.$v.'.dynamic',['only'=>['index','read','create','save','edit','update','delete']]],
        'api/heart_feeling'=>['api/'.$v.'.heart_feeling',['only'=>['index','read','save','delete']]],
        'api/error_log'=>['api/'.$v.'.error_log',['only'=>['index','read','save']]],

    ],

    'api/dynamic/mybook' => ['api/'.$v.'.dynamic/mybook',['method' => 'get']],
    'api/dynamic/user/:id' => ['api/'.$v.'.dynamic/user',['method' => 'get'],['id' => '\d+']],
    'api/user/:id'       => ['api/'.$v.'.user/read',['method' => 'get'], ['id' => '\d+']],
    'api/user/concern'   => ['api/'.$v.'.user/concern',['method' => 'get']],
    'api/user/friend'    => ['api/'.$v.'.user/friend',['method' => 'get']],
    'api/order/cancel/:id'   => ['api/'.$v.'.order/cancel',['method' => 'get'], ['id' => '\d+']],
    'api/order/checkOut/:id'   => ['api/'.$v.'.order/checkOut',['method' => 'get'], ['id' => '\d+']],

];
