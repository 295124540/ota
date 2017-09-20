<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class HotelOrder extends Model
{
    protected $autoWriteTimestamp = true;
    protected $type = [
        'total_money'=>'float:2',
        'pay_money'=>'float:2',
        'deduction_money'=>'float:2',
        'return_guaranty_money'=>'float:2'
    ];
    /**
     * 用户
     */
    public function user(){
        return $this->hasOne('Users','yunsu_id','user_id');
    }
}