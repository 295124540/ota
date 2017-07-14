<?php
namespace app\api\controller\v1;

use alyun\AliyunOss;
use common\controller\ActiveController;


class PhotoAlbum extends ActiveController
{
    protected $modelClass = 'no';
    protected $loginAuth =  ['except'=>'index,read'];

    /**
     * 书列表（最新、最热）
     */
    public function index(){
        success(AliyunOss::getPhotoAlbum("d"));
    }

    /**
     * 保存相册
     */
    public function save()
    {

    }

}
