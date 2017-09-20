<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class HotelRoom extends Model
{
    protected $type = [
        'price'=>'float:2',
    ];
    /**
     * 房间图片
     * @return \think\model\relation\HasMany
     */
    public function img(){
        return $this->hasMany('HotelRoomImg','room_id');
    }

}