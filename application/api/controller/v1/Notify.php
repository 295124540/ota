<?php
namespace app\api\controller\v1;

/**
 * 该类用于接收第三方服务器发来的通知、
 * 列如微信支付、支付宝支付
 */

use think\Controller;
use common\model\Order as OrderModle;
use common\model\CashPledge as CashPledgeModel;
use common\model\Users as UsersModel;

class Notify extends Controller{

    /**
     * 微信支付通知
     */
    public function wxpay(){

        $xml = file_get_contents("php://input");//替换方法
        //$xml = $GLOBALS ['HTTP_RAW_POST_DATA'];该方法已被php 5.6放弃  php 7.0完全不支持（坑一）
        $time = microtime(true);

        $fileName = "wxpay.txt";
        $file = fopen( $fileName,"a+");
        fwrite($file, $xml."\r\n");
        fclose($file);

        //libxml_disable_entity_loader(true);//禁止引用外部xml实体
        $xmlstring = simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA);
        $rt = json_decode(json_encode($xmlstring),true);
        if($rt['return_code']=="SUCCESS"){
            $orderId = $rt['out_trade_no'];
            $orderModel = OrderModle::get($orderId);
            if($orderModel){
                if( $orderModel->status == 0){
                    $orderModel->status = 1;//0:待付款；1：待发货；2：待收货；3：待评价；4：交易完成
                    $orderModel->save();
                    $userModel = UsersModel::get($orderModel->user_id);
                    if($userModel) {
                        $userModel->point = $userModel->point + $orderModel->total_money * 10;// 民宿下单支付成功获得10倍积分
                        $userModel->save();
                    }
                    if($orderModel->type==1){//民宿
                        $pledgeModel = new CashPledgeModel();
                        $pledgeModel->order_id = $orderModel->id;
                        $pledgeModel->user_id = $orderModel->user_id;
                        $pledgeModel->cash = 200;//民宿押金
                        $pledgeModel->save();
                    }
                }
            }
            return xml(['return_code'=>'SUCCESS','return_msg'=>'OK']);
        }else{
            return xml(['return_code'=>'FAIL','return_msg'=>'签名失败']);
        }
    }

    /**
     * 微信支付宝支付通知
     */
    public function alipay(){

        $payback = json_encode($_POST);

        $fileName = "alipay.txt";
        $file = fopen( $fileName,"a+");
        $content = "post:".$payback;
        fwrite($file, $content."\r\n");
        fclose($file);

        $paybackArr=json_decode($payback,true);

        if($paybackArr['trade_status']=='TRADE_SUCCESS'){
            echo 'success';
        }else{
            echo "response fail";
        }
    }

}
