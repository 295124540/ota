<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class Concern extends Model
{
    // 设置当前模型对应的完整数据表名称
    protected $table = 'ic_concern';

    // 设置当前模型的数据库连接
    protected $connection = [
        // 数据库类型
        'type'        => 'mysql',
        // 服务器地址
        'hostname'    => '120.76.232.65',
        // 数据库名
        'database'    => 'yunsu_users',
        // 数据库用户名
        'username'    => 'yunsu',
        // 数据库密码
        'password'    => 'yunsu.sql.root',
        // 数据库编码默认采用utf8
        'charset'     => 'utf8',
        // 数据库表前缀
        'prefix'      => 'ic_',
        // 数据库调试模式
        'debug'       => false,
    ];
}