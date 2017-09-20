<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class BookRent extends Model
{
    protected $type = [
        'guaranty_money'=>'float:2',
        'return_guaranty_money'=>'float:2'
    ];
    /**
     * 书籍
     * @return \think\model\relation\HasOne
     */
    public function book(){
        return $this->hasOne('Book','id','book_id');
    }

}