<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/11
 * Time: 16:30
 */

namespace app\api\controller\v1;


use common\controller\ActiveController;

class Signature extends ActiveController
{
    protected $modelClass = 'no';
    protected $rule = ['user_id'=>'require|max:200'];

    /**
     * 腾讯聊天
     */
    public function im(){
        $params = paramFromPost();
        $this->validate($params, $this->rule);
        $user = urlencode($params['user_id']);
        $url = "http://www.icloudinn.com:8080/yunsu-mobile-webapp/Server/user/getSignature?account=$user&t=1495548128676";

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

        $data['user_id']=$params['user_id'];
        $data['sdkAppID']="1400011424";
        $data['accountType']="5992";
        $data['imsig']=$imsig;
        success($data);
    }
}