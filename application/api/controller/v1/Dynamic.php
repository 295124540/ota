<?php
namespace app\api\controller\v1;

use common\controller\ActiveController;
use common\model\Dynamic as DynamicModel;
use common\model\Users as UsersModel;

class Dynamic extends ActiveController
{

    protected $modelClass = 'common\model\Dynamic';
    protected $order = "create_time desc";
    protected $loginAuth = ['except'=>'index,read,mood'];

    protected function prepareDataProvider()
    {
        $this->condition = "type!=4 and type!=5 ";

        $list = parent::prepareDataProvider(); // TODO: Change the autogenerated stub

        foreach ($list as $m){

            if($m->type==1){//民宿评论动态
                if($m->hotel){
                    foreach ($m->hotel->comment as $rp){
                        $rp->reply;//评论回复
                    }
                }
            }
            if($m->type==2){
                if($m->book){
                    foreach($m->book->comment as $rp){//书评动态
                        $rp->reply;//评论回复
                    }
                }
            }
            if ($m->type==3){
                $m->heartfeeling;//心情动态
            }

            foreach($m->dynamic_comment as $rp){//动态的评价
                $rp->reply;//评论回复
            }
        }
        return $list;
    }


    /**
     * 添加动态
     */
    public function save(){

        // 这样写有点恶心，但是为了解决前端完未完善用户资料就登录，用户信息缓存中无头像和昵称的情况
        if($this->user['nickname']==null||$this->user['nickname']==""){
            $user = UsersModel::get($this->userId)->toJson();
            if($user==null)error("用户不存在！");
            $this->user['nickname']=$user['nickname'];
            $this->user['head_img_url']=$user['head_img_url'];
        }

        $param = [
            'user_id'=> $this->userId,
            'user_name'=> $this->user['nickname'],
            'user_head_img'=>$this->user['head_img_url'],
            'topic'=>paramFromPost('topic',true),
            'imgs'=>paramFromPost('imgs'),
            'create_time' => time(),
        ];

        $modelClass = $this->modelClass;
        $m = $modelClass::create($param);
        if($m){
            success($m);
        }else{
            error($m->getError());
        }
    }

    /**
     * 点赞
     */
    public function praise(){
        $m = DynamicModel::get(paramFromPost('id',true));
        if($m){
            $m->praise_num = $m->praise_num+1;
            $m->save();
            success($m);
        }else{
            error("没有该ID的动态！");
        }

    }

    /**
     * 我的租书、捐书
     */
    public function myBook(){
        $list = DynamicModel::where("user_id=$this->userId and (type=4 or type=5)")->paginate(20);
        foreach ($list as $m){
            if($m->type==4){
                if($m->book_donate){
                    if($m->book_donate->book){
                        $commentNum = $m->book_donate->book->comment()->count();
                        $m->book_donate->book['comment_num'] = $commentNum;
                        if($m->book_donate->book){
                            $m->book_donate->book->model;
                        }
                    }
                }
            }
            if($m->type==5){
                if($m->book_rent){
                    if($m->book_rent->book){
                        $commentNum = $m->book_rent->book->comment()->count();
                        $m->book_rent->book['comment_num'] = $commentNum;
                        if($m->book_rent->book){
                            $m->book_rent->book->model;
                        }
                    }
                }
            }
        }
        success($list);
    }

    /**
     * 某人的心情动态，相册
     */
    public function  user($id){
        $this->condition = ['user_id'=>$id,'type'=>3];
        $list = parent::prepareDataProvider(); // TODO: Change the autogenerated stub
        foreach ($list as $m){
            if ($m->type==3){
                $m->heartfeeling;//心情动态
            }
            foreach($m->dynamic_comment as $rp){//动态的评价
                $rp->reply;//评论回复
            }
        }
        success($list->toArray());
    }
}
