<?php
namespace app\api\controller\v1;

use common\controller\ActiveController;

class HeartFeeling extends ActiveController
{

    protected $modelClass = 'common\model\HeartFeeling';
    protected $authenticate = ['except'=>'index,read'];

    /**
     * 上传图片
     */
    public function upload(){
        $files = request()->file();
        if($files==null){error("没收到任何文件！");}
        foreach($files as $key=>$file){
            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            $filePath =$info->getSaveName();
            if($info){
                $url = "/uploads/".str_replace('\\','/',$filePath);
                success($url);
            }else{
                // 上传失败获取错误信息
                $this->error($file->getError());
            }
        }
    }

    /**
     * 发布心情
     */
    public function save(){

        $param = [
            'user_id'=> $this->userId,
            'title'=>paramFromPost('title',true),
            'create_time' => time(),
        ];

        $imgs = paramFromPost('imgs');
        if(is_array($imgs)){
            $param['imgs']= $imgs;
        }else{
            $param['imgs']=json_decode($imgs,true);
        }

        $action = '发布了一条心情！';
        $location = paramFromPost('location');

        $modelClass = $this->modelClass;
        $m = $modelClass::create($param);
        if($m){

            if($this->saveDynamic($m->id,3,$action,$location)){
                success($m);
            }else{
                $m->delete();
            }
        }
        error($m->getError());
    }

}
