<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class DynamicComment extends Model
{
    protected $autoWriteTimestamp = true;
    protected $updateTime = false;

    protected $type = [
        'imgs'      =>  'array',
    ];
    /**
     * 评论回复
     */
    public function reply(){
        return $this->hasMany('DynamicCommentReply','comment_id');
    }
}