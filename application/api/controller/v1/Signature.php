<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/11
 * Time: 16:30
 */

namespace app\api\controller\v1;


use app\common\controller\ActiveController;
use think\Request;

class Signature extends ActiveController
{
    protected $modelClass = 'no';
    protected $authenticate = ['only'=>'im'];

    /**
     * 腾讯聊天
     */
    public function im(){
        $params = Request::instance()->get();
        $rule = ['account'=>'require'];
        $this->validate($params,$rule);
        $account = $params['account'];
        $url = "http://www.icloudinn.com:8080/yunsu-mobile-webapp/Server/user/getSignature?account=$account&t=".time();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $rs = curl_exec($ch);
        curl_close($ch);

        $rt = json_decode($rs,true);
        if($rt){
            $imsig = $rt['data'];
        }

        $data['account']=$account;
        $data['sdkAppID']="1400011424";
        $data['accountType']="5992";
        $data['imsig']=$imsig;
        success($data);
    }
}