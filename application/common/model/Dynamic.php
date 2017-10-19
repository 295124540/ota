<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class Dynamic extends Model
{

    protected $autoWriteTimestamp = true;

    /**
     * 用户信息
     */
    public function user(){
        return $this->hasOne('Users','yunsu_id','user_id')
            ->field('nickname,head_img_url');
    }

    /**
     * 1 民宿
     * @return \think\model\relation\HasMany
     */
    public function hotel(){
        return $this->hasOne('Hotel','id','source_id');
    }

    /**
     * 2 书
     * @return \think\model\relation\HasMany
     */
    public function book(){
        return $this->hasOne('Book','id','source_id');
    }

    /**
     * 3 心情
     * @return \think\model\relation\HasMany
     */
    public function heartfeeling(){
        return $this->hasOne('HeartFeeling','id','source_id');
    }

    /**
     * 动态评论
     */
    public function dynamicComment(){
        return $this->hasMany('DynamicComment','dynamic_id','id');
    }

    /**
     * 捐书
     */
    public function bookDonate(){
        return $this->hasOne('BookDonate','id','source_id');
    }

    /**
     * 著书
     */
    public function bookRent(){
        return $this->hasOne('BookRent','id','source_id');
    }

}