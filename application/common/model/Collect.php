<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class Collect extends Model
{
    /**
     * 收藏的民宿
     * @return \think\model\relation\HasOne
     */
    public function house(){
        return $this->hasOne('House','id','source_id');
    }

    /**
     * 收藏的书
     * @return \think\model\relation\HasOne
     */
    public function book(){
        return $this->hasOne('Book','id','source_id');
    }
}