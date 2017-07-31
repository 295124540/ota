<?php
namespace app\api\controller\v1;

use common\controller\ApiBaseController;

use Payment\ChargeContext;
use Payment\Config;
use Payment\Common\PayException;
use common\model\HotelOrder as HotelOrderModel;
use common\model\BookRent as BookRentModel;
use think\Request;

class WechatPay extends ApiBaseController
{
    protected $loginAuth = ['except'=>'index'];
    protected $rule = [
        'hotel_order_id'  => 'require',
        'pay_way'  => 'require|in:APP,QR,LITE,PUB',
        'wx_openid'=>'requireIf:pay_way,LITE|requireIf:pay_way,PUB',
        'rent_id'=>'require'
    ];
    protected $msg = [
        'hotel_order_id.require' => 'hotel_order_id民宿订单ID不能为空！',
        'pay_way.require'=>'pay_way支付方式不能为空！',
        'pay_way.in'=>'pay_way必须在 APP,QR,LITE,PUB 范围内，APP支付,QR扫码支付,LITE小程序支付,PUB公众号支付',
        'wx_openid.requireIf'=>'wx_openid小程序、公众号支付，微信openID不能为空！',
        'rent_id.require'=>'rent_id租书ID不能为空'
    ];
    protected $scene = [
        'hotel_order'  =>  ['hotel_order_id','pay_way','wx_openid'],
        'rent_book'   =>  ['rent_id','pay_way','wx_openid']
    ];

    /**
     * 支付
     * @param $param
     * @param $payData
     * @return mixed|string
     */
    protected function pay($param ,$payData){

        if($param['pay_way']=='QR') {
            // 微信扫码支付，需要设置的参数
            $payData['product_id']  = '123456';
        }

        if($param['pay_way']=='LITE'||$param['pay_way']=='PUB'){
            // 微信公众号支付，需要的参数
            $payData['openid'] = $param['wx_openid'];// 需要通过微信提供的api获取该openid
        }

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
            if($param['pay_way']=='QR') {

                $type = Config::WX_CHANNEL_QR;// 微信 扫码支付

            }elseif($param['pay_way']=='APP') {

                $type = Config::WX_CHANNEL_APP;// 微信 APP支付

            }elseif($param['pay_way']=='LITE') {

                $type = Config::WX_CHANNEL_LITE;//微信 小程序支付

            }elseif($param['pay_way']=='PUB') {

                $type = Config::WX_CHANNEL_PUB; // 微信 公众号支付
            }

            $charge->initCharge($type, $wxconfig);
            $ret = $charge->charge($payData);
        } catch (PayException $e) {

            api(0,'微信服务器返回预付订单错误！',$e->errorMessage());

        }

        if ($type === Config::WX_CHANNEL_QR) {
            $data = urlencode($ret);
            $url = "http://paysdk.weixin.qq.com/example/qrcode.php?data={$data}";
            return $url;
        }else {
           return json_decode($ret,true);
        }
    }


    public function hotelOrder(){

        $param = Request::instance()->param();
        $this->validateByScene1($param,'hotel_order');

        $order = HotelOrderModel::get(['hotel_order_id'=>$param['hotel_order_id'],'user_id'=>$this->userId]);
        if($order==null)error('对不起，你没有该订单！');
        if($order->status==-1)error('该订单已取消！');
        if($order->status>0)error('该订单已支付，请勿重复支付！');
        $payMoney = $order->pay_money;
        if($payMoney<=0)error('此订单为免费订单无需支付！');
        $attach = ['action'=>'hotel_order'];

        // 订单信息
        $payData = [
            "order_no"	=> $order->hotel_order_id,
            "amount"	=> $payMoney+200,//后面200是押金，支付通知成功时写入数据表
            //"amount"	=> 0.01,
            "client_ip"	=> '127.0.0.1',
            "subject"	=> '在线支付',
            "body"	=> '云宿网络',
            "return_param"	=> json_encode($attach),//string 附加数据，在查询API和支付通知中原样返回
            'timeout_express'	=> strtotime("+24 hours")//订单过期时间
        ];

       success($this->pay($param,$payData));
    }

    /**
     * 支付租书押金
     */
    public function rentBookGuaranty(){

        $param = Request::instance()->param();
        $this->validateByScene1($param,'rent_book');
        $brm = BookRentModel::get(['id'=>$param['rent_id'],'user_id'=>$this->userId]);
        if($brm == null)error("你没有该租书ID的记录！");
        if($brm->status==1)$this->error("已经支付租书押金，请勿重复支付！");
        $money = $brm->guaranty_money;
        if($money<=0)error('此书无需押金！');

        $attach = ['action'=>'rent_book','rent_id'=>$brm->id];

        // 订单信息
        $payData = [
            "order_no"	=> 'RB'.time(),// 商户网站唯一订单号
            "product_id"=> $brm->id,// 商品ID
            "amount"	=> 0.01,
            //"amount"	=> $brm->guaranty_money,
            "client_ip"	=> '127.0.0.1',
            "subject"	=> '在线支付', // 商品名称,该参数最长为128个汉字
            "body"	=> '租书押金',// 商品描述
            "return_param"	=> json_encode($attach),//string 附加数据，在查询API和支付通知中原样返回
            'timeout_express'	=> strtotime("+24 hours")//订单过期时间
        ];

        success($this->pay($param,$payData));
    }
}
