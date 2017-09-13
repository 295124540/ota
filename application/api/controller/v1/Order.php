<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 18:05
 */

namespace app\api\controller\v1;

use common\controller\ActiveController;
use common\model\House as HouseModel;
use common\model\Room as RoomModel;
use common\model\Book as BookModel;
use common\model\Order as OrderModel;
use common\model\HotelReservation;
use common\model\Users as UsersModel;


class Order extends ActiveController
{
    protected $modelClass = 'common\model\Order';
    protected $order = "create_time desc";
    protected $condition = ['type'=>1];

    protected $rule = [
        'source_id'  => 'require|max:25',
        'type'   => 'number|between:0,5',
        'num' => 'number|between:0,20',
        'pay_money' => 'number|between:0,10000',
        'num' => 'number|between:0,20',
    ];

    protected function findModel($id)
    {
        $m = OrderModel::get(['user_id'=>$this->userId,'id'=>$id]);
        if($m){
            return $m;
        }else{
            error('你没有该订单哦！');
        }
    }


    /**
     * 订单列表
     */
    public function index()
    {
        $this->condition['user_id'] = $this->userId;
        $list = $this->prepareDataProvider();
        foreach ($list as $model){
            $model->item;
        }
        success($list);
    }

    /**
     * 订单详情
     */
    public function read($id)
    {
        $this->condition['user_id'] = $this->userId;
        $model = $this->findModel($id);
        $model->item;
        success($model);
    }

    /**
     * 预订下单
     */
    public function save(){

        $this->validate(paramFromPost(),$this->rule);
        $params['user_id']=$this->userId;
        $params['user_name']=$this->user['nickname'];
        $params['source_id']=paramFromPost('source_id',true);
        $params['type']=paramFromPost('type',true);
        $params['pay_money']=(float)paramFromPost('pay_money',true);
        $params['discount_money']=(float)paramFromPost('discount');
        $params['total_money'] = $params['pay_money']+$params['discount_money'];

        //民宿
        if($params['type']==1){
            $params['arrive_time']=paramFromPost('arrive_time',true);
            $params['leave_time']=paramFromPost('leave_time',true);

            $list = HouseModel::all($params['source_id']);
            if($list==null){
                error("对不起，该民宿不存在！");
            }

            foreach ($list as $m){
                $params['describe'] = $m->name;
                $hotelImg = $m->img[0]['url'];// 民宿主图，用来订单封面
            }

            $roomId = paramFromPost('room_id');
            if($roomId==null){//整套
                $type = 0;
                $this->reservation($params['source_id'],$params['arrive_time'],$params['leave_time']);//整套、写入民宿预订时间
            }else{//单套
                $list = RoomModel::all($roomId);
                $type = 1;
                $this->reservation($params['source_id'],$params['arrive_time'],$params['leave_time'],$roomId);//单间、写入民宿预订时间
            }

            $model = new OrderModel($params);
            $model->allowField(true)->save();
            foreach ($list as $k=>$m){

                $item[$k] = [
                    'source_id'=>$m->id,
                    'type'=>$type,
                    'source_name'=>$m->name,
                    'img'=>$m->img?$m->img[0]['url']:$hotelImg,
                    'price'=>$m->price,
                    'num'=>1,
                    'total_money'=>1*$m->price
                ];
            }
            if(isset($item)){
                $model->item()->saveAll($item);
            }

            $userModel = UsersModel::get($this->userId);
            if($userModel){
                if($params['discount_money']){
                    $userModel->point = $userModel->point- ($params['discount_money']*50);// 50个积分可以抵扣1元钱
                    $userModel->save();
                }
            }
        }

        //书
        if($params['type']==2){
            $bookModelClass = 'common\model\Book';
            $list = $bookModelClass::all($params['source_id']);
            if($list==null){
                error("对不起，该书不存在！");
            }

            foreach ($list as $book){
                $params['describe'] = $book->model->name;
            }
            $model = new OrderModel($params);
            $model->allowField(true)->save();

            foreach ($list as $k=>$m){
                $item[$k] = [
                    'source_id'=>$m->id,
                    'source_name'=>$m->model->name,
                    'img'=>$m->model->cover_img,
                    'price'=>$m->price,
                    'num'=>1,
                    'total_money'=>1*$m->price
                ];
            }
            if(isset($item)){
                $model->item()->saveAll($item);

            }
        }

        if(!isset($list)){
            error("目前系统只支持民宿、书籍的购买！");
        }

        if($model){
            $model->item;
            api(100,"下单成功",$model);
        }else{
            error("失败！".$model->getError());
        }

    }

    /**
     * 用户取消订单
     */
    public function cancel($id){
        $order = $this->findModel($id);
        if($order->status!=0){
            if($order->status==-1){
                error("该订单状态为：".$order->status.",已经取消,请勿重复操作！");
            }else{
                error("该订单状态为：".$order->status.",不满足取消条件！");
            }
        }
        $order->status = -1;
        if($order->save()){
            api(100,"取消成功！");
        }else{
            error("取消失败！");
        }
    }

    /**
     * 退房
     */
    public function checkOut($id){
        $order = $this->findModel($id);
        if($order->status !=1) error("你的订单不满足退房要求,状态码：".$order->status);
        $order->status = 2 ;//待退房
        if($order->save()){
            api(100,"退房成功！");
        }else{
            error("退房失败！".$order->getError());
        }

    }

    /**
     * 民宿预订
     */
    protected function reservation($hotelId,$checkInDate,$checkOutDate,$roomId = null){

        //入住
        $y1 = (int)date("Y",$checkInDate);
        $m1 = (int)date("m",$checkInDate);
        $d1 = (int)date("d",$checkInDate);

        //退房
        $y2 = (int)date("Y",$checkOutDate);
        $m2 = (int)date("m",$checkOutDate);
        $d2 = (int)date("d",$checkOutDate);

        $max = date('t', $checkInDate);//该月天数

        //预订时间算法
        $list = [];
        if($y1==$y2){
            if($m1==$m2){
                for ($i=$d1; $i <$d2; $i++) {
                    $list[]['date']=$y1."-".$m1."-".$i;
                }

            }else{
                for ($i=$d1; $i <=$max; $i++) {
                    $list[]['date']=$y1."-".$m1."-".$i;
                }
                for ($i=1; $i <$d2; $i++) {
                    $list[]['date']=$y1."-".$m2."-".$i;
                }
            }
        }else{
            for ($i=$d1; $i <=$max; $i++) {
                $list[]['date']=$y1."-".$m1."-".$i;
            }
            for ($i=1; $i <$d2; $i++) {
                $list[]['date']=$y2."-".$m2."-".$i;
            }
        }

        foreach ($list as $k=>$v){
            if($roomId){
                $model = HotelReservation::get(['hotel_id'=>$hotelId,'room_id'=>$roomId,'date'=>$v['date']]);//单间情况
                $list[$k]['hotel_id']=$hotelId;
                $list[$k]['room_id']=$roomId;
            }else{
                $model = HotelReservation::get(['hotel_id'=>$hotelId,'date'=>$v['date']]);//整套情况
                $list[$k]['hotel_id']=$hotelId;
            }
            if($model)error("该民宿在".$v['date']."日期已经被预定！");

        }

        $model = new HotelReservation();
        $model->saveAll($list);

    }
}