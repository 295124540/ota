<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class Hotel extends Model
{
    protected $type = [
        'price'=>'float:2',
    ];
    /**
     * 民宿图片
     * @return \think\model\relation\HasMany
     */
    public function img(){
        return $this->hasMany('HotelImg','hotel_id');
    }

    /**
     * 套间列表
     * @return \think\model\relation\HasMany
     */
    public function room(){
        return $this->hasMany('HotelRoom','hotel_id');
    }

    /**
     * 配套设施
     * @return \think\model\relation\BelongsToMany
     */
    public function support()
    {
        return $this->belongsToMany('HotelSupportFacility','hotel_support','support_id','hotel_id');
    }

    /**
     * 用户评论
     * @return \think\model\relation\HasMany
     */
    public function comment(){
        return $this->hasMany('Comment','source_id')->where('type',1);
    }

}