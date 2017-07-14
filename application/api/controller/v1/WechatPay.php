<?php
namespace app\api\controller\v1;

use common\controller\ApiBaseController;

use Payment\ChargeContext;
use Payment\Config;
use Payment\Common\PayException;
use common\model\Order as OrderModel;
use common\model\BookRent as BookRentModel;

class WechatPay extends ApiBaseController
{
    protected $beforeActionList = [
        'loginAuth' =>  ['except'=>'index'],
    ];

    public function wechatApp(){

        $orderId = paramFromPost('order_id',true);
        $order = OrderModel::get(['id'=>$orderId,'user_id'=>$this->userId]);
        if($order==null)error('对不起，你没有该订单！');
        if($order->status!=0)error('该订单已支付，请勿重复支付！');
        $payMoney = $order->pay_money;
        if($payMoney<=0)error('此订单为免费订单无需支付！');

        // 订单信息
        $payData = [
            "order_no"	=> $order->id,
            //"amount"	=> $payMoney+200,//后面200是押金，支付通知成功时写入数据表
            "amount"	=> 0.01,
            "client_ip"	=> '127.0.0.1',
            "subject"	=> '在线支付',
            "body"	=> '云宿网络',
            "extra_param"	=> '888888888888888888888888888888888',
            'timeout_express'	=> strtotime("+24 hours")//订单过期时间
        ];

        // 微信扫码支付，需要设置的参数
        // $payData['product_id']  = '123456';

        // 微信公众号支付，需要的参数
        $payData['openid'] = $this->user['wx_openid'];// 需要通过微信提供的api获取该openid

        /**
         * 包含客户的配置文件
         * 本次 2.0 版本，主要的改变是将配置文件独立出来，便于客户多个账号的情况
         * 已经使用不同方式读取配置文件，如：db  file   cache等
         */
        $wxconfig = config('thirdaccount.wechat_pay');

        /**
         * 实例化支付环境类，进行支付创建
         */
        $charge = new ChargeContext();

        try {

            // 微信 扫码支付
            // $type = Config::WX_CHANNEL_QR;

            // 微信 APP支付
            //$type = Config::WX_CHANNEL_APP;

            //微信 小程序支付
            $type = Config::WX_CHANNEL_LITE;

            // 微信 公众号支付
            //$type = Config::WX_CHANNEL_PUB;


            $charge->initCharge($type, $wxconfig);
            $ret = $charge->charge($payData);
        } catch (PayException $e) {

            api(0,'微信服务器返回预付订单错误！',$e->errorMessage());
        }

        if ($type === Config::WX_CHANNEL_QR) {
            $url = urlencode($ret);
            echo "<img alt='扫码支付' src='http://paysdk.weixin.qq.com/example/qrcode.php?data={$url}' style='width:150px;height:150px;'/>";

        } elseif ($type === Config::WX_CHANNEL_PUB) {
            success(json_decode($ret,true));
        } elseif (stripos($type, 'wx') !== false) {
            success($ret);
        }


    }

    /**
     * 支付租书押金
     */
    public function RentBookDeposit(){
        $rentId = paramFromPost('rent_id',true);
        $brm = BookRentModel::get(['id'=>$rentId,'user_id'=>$this->userId]);
        if($brm == null);error("该书无法租用");

    }
}
