<?php
namespace app\api\controller\v1;

use common\controller\ApiBaseController;
use think\Db;

use common\model\Users as UsersModel;
use common\model\Concern;
use common\model\Order;
use common\model\BookDonate;
use common\model\BookRent;

class User extends ApiBaseController
{

    protected  $loginAuth = ['only'=>'read,update,isMember,concern'];


    public function index(){
        $list = UsersModel::paginate(20);
        foreach ($list as $m){
            $m2 = Concern::get(['user_id'=>$this->userId,'concern_user_id'=>$m->yunsu_id]);
            if($m2){
                $m['is_concern'] = 1;
            }else{
                $m['is_concern'] = 0;
            }

            $m['rent_book_num']=0;
            $m['donate_book_num']=0;
            $m['check_in_hotel_num']=0;
        }
        success($list);
    }

    /**
     * 用户详情
     */
    public function read($id){
        $user = UsersModel::get($id);
        if($user){
            $user = $user->visible(['yunsu_id','nickname','head_img_url','sex','city',])->toArray();
            $user['rent_book_num']=0;
            $user['donate_book_num']=0;
            $user['check_in_hotel_num']=0;
            $m = Concern::get(['user_id'=>$this->userId,'concern_user_id'=>$id]);
            if($m){
                $user['is_concern'] = 1;
            }else{
                $user['is_concern'] = 0;
            }
            success($user);
        }else{
            error("不存在该用户！");
        }

    }


    /**
     * 我关注的\关注我的  列表
     */
    public function concern(){
        $type = paramFromGet("type");
        $page = paramFromGet("page");
        $path = '/api/concern?type='.$type;
        if($page){
            $path = $path."&page=".$page;
        }
        $data = $this->requestUserServer($path);
        $f = 'concern_user_id';
        if($type==1)$f = 'user_id';
        if($data['data']){
            foreach ($data['data'] as $k=>$m){
                $data['data'][$k]['user']['rent_num'] = BookRent::where(['user_id'=>$m[$f]])->count();
                $data['data'][$k]['user']['donate_num'] = BookDonate::where(['user_id'=>$m[$f]])->count();
                $data['data'][$k]['user']['check_in_hotel_num'] = Order::where(['user_id'=>$m[$f]])->count();
            }
        }
        success($data);
    }

    /**
     * 书虫
     * 分析动态列表
     */
    public function bookworm(){
        $list = Db::query('SELECT user_id,user_name,user_head_img,count(type=4 or null) donate_num,count(type=5 or null) rent_num FROM ot_dynamic  GROUP BY user_id ORDER BY donate_num DESC LIMIT 20');
        foreach ($list as $k=>$v){
            $m = Concern::get(['user_id'=>$this->userId,'concern_user_id'=>$v['user_id']]);
            if($m){
                $list[$k]['is_concern'] = 1;
            }else{
                $list[$k]['is_concern'] = 0;
            }
        }
        success($list);
    }

    /**
     * 查询是否是会员
     * 捐过书的人或者住过民宿的人
     */
    public function isMember(){

        $order = Order::get(['user_id'=>$this->userId,'status'=>1]);
        $donate = BookDonate::get(['user_id'=>$this->userId,'status'=>1]);
        if($order||$donate){
            api(100,"是会员",true);
        }else{
            api(100,"不是会员",false);
        }
    }


}
