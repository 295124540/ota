<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class CashPledge extends Model
{
    protected $autoWriteTimestamp = true;
    /**
     * 订单项
     */
    public function order(){
        return $this->hasOne('Order','id','order_id');
    }
}