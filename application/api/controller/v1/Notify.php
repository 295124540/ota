<?php
namespace app\api\controller\v1;

/**
 * 该类用于接收第三方服务器发来的通知、
 * 列如微信支付、支付宝支付
 */

use common\model\Book;
use think\Controller;
use common\model\HotelOrder as HotelOrderModle;
use common\model\Users as UsersModel;
use common\model\BookRent as BookRentModel;
use common\model\Dynamic as DynamicModel;

class Notify extends Controller{

    /**
     * 租书状态
     */
    protected function setRentBook($rentId){
        $rentModel = BookRentModel::get($rentId);
        if($rentModel){
            // 1改变租书记录状态
            $rentModel->status = 1;
            $rentModel->save();

            $userModel = UsersModel::get($rentModel->user_id);
            if($userModel){

                // 2租书获得1积分
                $userModel->point = $userModel-> point + 30;
                $userModel->save();

                // 3生成动态
                // 0未知 1心情  2民宿评 3书评 4捐书 5租书
                $m = DynamicModel::get(['source_id'=>$rentModel->id,'type'=>5]);
                if(!$m){
                    $param = [
                        'user_id'=> $userModel->yunsu_id,
                        'user_name'=>  $userModel->nickname,
                        'user_head_img'=> $userModel->head_img_url,
                        'source_id'=>$rentModel->id,
                        'type'=>5,
                        'action'=>"租了一本书：《".$rentModel->book->model->name."》",
                    ];
                    DynamicModel::create($param);
                }
            }

            // 4改变书的状态
            $bookModel = Book::get($rentModel->book_id);
            if($bookModel){
                $bookModel->status = 2;
                $bookModel->save();
            }
        }
    }

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
            $attach = json_decode($rt['attach'],true);
            // 民宿预订
            if($attach['action']=='hotel_order'){
                $orderId = $rt['out_trade_no'];
                $orderModel = HotelOrderModle::get($orderId);
                if($orderModel){
                    if( $orderModel->status == 0){
                        $orderModel->status = 1;//0:待付款；1：待发货；2：待收货；3：待评价；4：交易完成
                        $orderModel->save();
                        $userModel = UsersModel::get($orderModel->user_id);
                        if($userModel) {
                            $userModel->point = $userModel->point + $orderModel->total_money * 10;// 民宿下单支付成功获得10倍积分
                            $userModel->save();
                        }
                    }
                }
            }
            // 租书押金支付
            if($attach['action']=='rent_book'){
                $this->setRentBook($attach['rent_id']); // 配合吊起支付来写
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
