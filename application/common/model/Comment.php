<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/11
 * Time: 16:56
 */

namespace app\common\model;

use think\Model;

class Comment extends Model
{
    protected $type = [
        'imgs'      =>  'array',
    ];
    /**
     * 评论回复
     */
    public function reply(){
        return $this->hasMany('CommentReply','comment_id');
    }
}