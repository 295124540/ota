<?php
/**
 * 后台菜单配置
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/15
 * Time: 9:22
 */
return [
    [
        'name' => '基础信息',
        'icon'=>'/static/img/icon_menu_function.png',
        'auth_role' => '1,2,3',
        'item' => [
            [
                'name' => '首页',
                'url' => '/admin',
                'auth_role' => '1,2,3'
            ],
        ]
    ],
    [
        'name' => '旅游服务',
        'icon'=>'/static/img/icon_menu_ad.png',
        'auth_role' => '1,2',
        'item' => [
            [
                'name' => '民宿客栈',
                'url' => '/admin/hotel',
                'auth_role' => '1,2,3'
            ],
            [
                'name' => '配套设施',
                'url' => '/admin/support_facility',
                'auth_role' => '1'
            ],
            [
                'name' => '民宿订单',
                'url' => '/admin/order',
                'auth_role' => '1,2,3'
            ],
        ]
    ],
    [
        'name' => '文化公益',
        'icon'=>'/static/img/icon_menu_statistics.png',
        'auth_role' => '1,3',
        'item' => [
            [
                'name' => '书屋管理',
                'url' => '/admin/book_house',
                'auth_role' => '1,2'
            ],
            [
                'name' => '书童管理',
                'url' => '/admin/user/child',
                'auth_role' => '1'
            ],
            [
                'name' => '书库管理',
                'url' => '/admin/book',
                'auth_role' => '1,2,3'
            ],
            [
                'name' => '捐书管理',
                'url' => '/admin/book_donate',
                'auth_role' => '1,2,3'
            ],
            [
                'name' => '租书管理',
                'url' => '/admin/book_rent',
                'auth_role' => '1,2,3'
            ],
            [
                'name' => '著书管理',
                'url' => '/admin/book_write',
                'auth_role' => '1,2,3'
            ],
        ]
    ],
    [
        'name' => '智能硬件',
        'icon'=>'/static/img/icon_menu_ad.png',
        'auth_role' => '1,2',
        'item' => [
            [
                'name' => '智能门锁',
                'url' => '/admin/house',
                'auth_role' => '1,2'
            ],
            [
                'name' => '二维码打印机',
                'url' => '/admin/house',
                'auth_role' => '1,2'
            ],
        ]
    ],
    [
        'name' => '数据统计',
        'icon'=>'/static/img/icon_menu_management.png',
        'auth_role' => '1,2,3',
        'item' => [
            [
                'name' => '用户统计',
                'url' => '#',
                'auth_role' => '1,2,3'
            ],
            [
                'name' => '访问统计',
                'url' => '#',
                'auth_role' => '1'
            ],
            [
                'name' => '交易统计',
                'url' => '#',
                'auth_role' => '1,2,3'
            ],
        ]
    ],
    [
        'name' => '系统管理',
        'icon'=>'/static/img/icon_menu_setup.png',
        'auth_role' => '1',
        'item' => [
            [
                'name' => '运营者管理',
                'url' => '/admin/user/getList',
                'auth_role' => '1'
            ],
            [
                'name' => '数据库',
                'url' => '#',
                'auth_role' => '1,2,3'
            ],
            [
                'name' => '系统缓存',
                'url' => '#',
                'auth_role' => '1,2,3'
            ],
            [
                'name' => '错误日志',
                'url' => '/admin/error_log',
                'auth_role' => '1,2,3'
            ],
        ]
    ],
    [
        'name' => '投诉咨询',
        'icon'=>'/static/img/icon_menu_developer.png',
        'auth_role' => '1,2,3',
        'item' => [
            [
                'name' => '游客咨询',
                'url' => '#',
                'auth_role' => '1,2,3'
            ],
            [
                'name' => '投诉建议',
                'url' => '#',
                'auth_role' => '1,2,3'
            ],
        ]
    ],
];