<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 18:05
 */

namespace app\api\controller\v1;

use common\controller\ActiveController;
use common\model\Comment as CommentModel;
use common\model\CommentReply as CommentReplyModel;
use common\model\Order as OrderModel;
use common\model\Users as UsersModel;

class Comment extends ActiveController{

    protected $modelClass = 'common\model\Comment';

    /**
     * 评论
     */
    public function save(){

        $sourceId = paramFromPost('source_id',true);
        $type = paramFromPost('type',true);
        $params['type']= $type;

        if($params['type']==1){
            $orderId = paramFromPost('order_id',true);
            $order = OrderModel::get(['id'=>$orderId,'user_id'=>$this->userId]);
            if($order==null)error("你没有该订单哦！");
            if($order->status == 4)error("你已经评价过了！");
            if($order->status != 3)error("不满足评论条件哦！");
            $order->status = 4;//改变订单状态,已评价、交易完成
            $order->save();
            $action = "评论了民宿！";
        }

        if($params['type']==2){
            $action = "写了一个书评！";
        }

        if($params['type']==3){
            $action = "评论了主人的心情！";
        }

        $imgs = paramFromPost('imgs');
        if(is_array($imgs)){
            $params['imgs']= $imgs;
        }else{
            $params['imgs']=json_decode($imgs,true);
        }

        $params['source_id'] = $sourceId;
        $params['content']=paramFromPost('content',true);
        $params['user_id']=$this->userId;
        $params['user_name']=$this->user['nickname'];
        $params['head_img']=$this->user['head_img_url'];
        $params['recommend_exponent']=paramFromPost('recommend_exponent');
        $params['location']=paramFromPost('location');
        $params['create_time']=time();

        $m = CommentModel::create($params);
        if($m){

            $this->saveDynamic($sourceId,$type,$action);

            if($params['type']==2){
                $userModel = UsersModel::get($m->user_id);
                if($userModel){
                    $userModel->point = $userModel->point + 50;// 书评获得1积分
                    $userModel->save();
                }
            }
            api(100,"评论成功！",$m);
        }else{
            error("评论失败！");
        }
    }


    /**
     * 回复
     */
    public function reply(){

        $params = paramFromPost();
        $validate = [
            ['comment_id|comment_id,动态评价ID','require|max:30'],
            ['reply|reply,回复的语句','require|max:100'],
        ];

        if(!CommentModel::get($params['comment_id'])){
            error("该评论不存在！");
        }
        $this->validate($params,$validate);
        $params['user_name'] = $this->user['nickname'];
        $params['create_time'] = time();
        $model = new CommentReplyModel($params);
        $model->allowField(true)->save();

        if($model){
            success($model);
        }else{
            error("回复失败！");
        }

    }

    /**
     * 点赞评论
     */
    public function praise(){
        $commentId = paramFromPost('comment_id',true);
        $action = paramFromPost('action',true);
        $m = CommentModel::get($commentId);
        if($m==null)error("不存在该评论！");
        if($action=='praise'){
            $m->praise_num = $m->praise_num + 1;
        }elseif($action=='cancel'){
            $m->praise_num = $m->praise_num - 1;
        }else{
            error("action错误");
        }
        if($m->save()){
            success($m);
        }else{
            error("点赞失败了");
        }
    }
}