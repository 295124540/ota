<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class Book extends Model
{
    protected $type=[
        'price'=>'float:2'
    ];

    public function book(){
        return $this->alias('b')->join('__BOOK_MODEL__ m','m.id = b.model_id')
            ->field('b.id book_id,name,cover_img,rent_num,read_num');
    }
    /**
     * 书模
     * @return \think\model\relation\HasOne
     */
    public function model(){
        return $this->hasOne('BookModel','id','model_id');
    }

    /**
     * 书模 例如：5本相同的书，在不同的名宿，为了区分这些书，必须每本书都给ID，
     * 但是5本书信息是一样的，所有用另一张表来保存这些基本信息 这张表就是book_model
     * @return \think\model\relation\HasOne
     */
    public function bookModel(){
        return $this->hasOne('BookModel','id','model_id');
    }

    public function template(){
        return $this->hasOne('BookModel','id','model_id')->bind('name,cover_img');
    }

    /**
     * 评论
     * @return \think\model\relation\HasMany
     */
    public function comment(){
        return $this->hasMany('Comment','source_id')->where('type',2);
    }

    /**
     * 谁捐的
     * @return \think\model\relation\HasOne
     */
    public function bookDonate(){
        return $this->hasOne('BookDonate','book_id');
    }

    /**
     * 哪些人租了
     * @return \think\model\relation\HasOne
     */
    public function bookRent(){
        return $this->hasMany('BookRent','book_id');
    }

    /**
     * 所在书屋
     * @return \think\model\relation\HasOne
     */
    public function bookHouse(){
        return $this->hasOne('BookHouse','id','book_house_id');
    }


}