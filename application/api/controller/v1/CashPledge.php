<?php
namespace app\api\controller\v1;

use common\controller\ActiveController;
use common\model\CashPledge as CashPledgeModel;
use common\model\Order as OrderModel;

class CashPledge extends ActiveController
{
    protected $modelClass = 'common\model\CashPledge';
    protected $beforeActionList = [
        'loginAuth' =>  ['except'=>'index,read'],
    ];

    public function save()
    {
        $oderId = paramFromPost("order",true);
        $cashPledge = paramFromPost("cash_pledge",true);

        $orderModel = OrderModel::get($oderId);
        if($orderModel==null)error("该订单不存在哦！");
        $model = CashPledgeModel::get(['order_id'=>$orderModel]);
        if($model==null){
            $model = new CashPledgeModel();
            $model->user_id = $this->userId;
            $model->order_id =$oderId;
            $model->cash_pledge = $cashPledge;
            $model->save();
        }else{
            api(100,"已经交付押金了！",$model);
        }

    }
}
