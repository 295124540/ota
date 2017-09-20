<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class BookWrite extends Model
{
    /**
     * 全部章节
     * @return \think\model\relation\HasMany
     */
    public function chapter(){
        return $this->hasMany("BookWriteChapter","book_write_id")->order('sequence DESC');
    }

    /**
     * 最新章节
     * @return \think\model\relation\HasOne
     */
    public function newChapter(){
        return $this->hasOne("BookWriteChapter","book_write_id")->order('sequence DESC')->limit(1);
    }
}