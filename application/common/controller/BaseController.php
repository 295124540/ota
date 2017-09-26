<?php
/**
 * Created by PhpStorm.
 * User: chen
 * Date: 2017/9/25
 * Time: 15:11
 */

namespace app\common\controller;


use alyun\AliyunOss;
use think\Controller;

class BaseController extends Controller
{
    /**
     * 上传图片到阿里云
     */
    protected function uploadToAlyun($file)
    {
        $dir = 'images/';//存放目录
        $url = AliyunOss::uploadFile($dir,$file);
        return $url;
    }

}