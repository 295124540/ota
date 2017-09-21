<?php
namespace app\admin\controller;

use common\controller\AdminController;
use think\Request;
use common\model\Hotel as HouseModel;
use common\model\Category as CategoryModel;
use common\model\HotelRoom as RoomModel;

class Room extends AdminController
{

    protected $modelClass = 'common\model\HotelRoom';

    protected $beforeActionList = [
        'preposition'  =>  ['only'=>'index,create,save,edit,update,delete'],
    ];


    /**
     * 前置操作
     */
    protected function  preposition(){
        $houseId = paramFromGet('hotel_id');
        if($houseId==null){
            $referer = urldecode(Request::instance()->header('Referer'));
            if($referer){
                preg_match('/hotel_id=(?<right>.*)/', $referer, $matches);
                if($matches){
                    $houseId = $matches[1];
                }
            }
        }
        if($houseId==null){
            exception('没有提供民宿ID', 100006);
        }
        $typeList = CategoryModel::all(['resource_type'=>1]);

        $this->condition = ['hotel_id'=>$houseId];
        $this->setAssign(['houseId'=>$houseId,'typeList'=>$typeList]);
    }

    /**
     * find model
     * @param $id
     * @return mixed
     */
    protected function findModel($id)
    {
        $model= parent::findModel($id);
        $model->img;
        return $model;
    }

    /**
     * 修改套间信息
     */
    public function save(){

        $params = request()->param();
        //图片上传
        $files = request()->file('image');
        $picList = array();
        foreach($files as $key=>$file){

            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            $filePath =$info->getSaveName();
            if($info){
                $picList[] = [
                    'serial_num'=>$key,
                    'url'=>"/uploads/".str_replace('\\','/',$filePath)
                ];
            }

        }

        $model = new RoomModel($params);
        $rt = $model->allowField(true)->save();
        $model->img()->saveAll($picList);
        if($rt){
            $this->success("房间添加成功！","index");
        }else{
            $this->error("房间添加失败!");
        }
    }

    /**
     * 修改套间信息
     */
    public function update($id){

        $params = request()->param();
        //图片上传
        $files = request()->file('image');
        $picList = array();

        $model = RoomModel::get($id);
        foreach($files as $key=>$file){

            $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
            $filePath =$info->getSaveName();
            if($info){
                $url = "/uploads/".str_replace('\\','/',$filePath);
                if(isset($params['imageId'][$key])){
                    $list = [
                        'id'=>$params['imageId'][$key],
                        'url'=>$url,
                    ];
                    $model->img()->update($list);
                }else{
                    $picList[] = [
                        'serial_num'=>$key,
                        'url'=>$url,
                    ];
                }
            }

        }
        $model->allowField(true)->save($params);
        $model->img()->saveAll($picList);

        $this->success("房间修改成功！","index");
    }

}
