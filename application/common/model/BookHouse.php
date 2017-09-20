<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class BookHouse extends Model
{
    function admin(){
        return $this->hasOne('Admin','id','child_id');
    }
}