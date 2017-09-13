<?php 
namespace admin\base\controller;
use admin\Common;
use common\model\town\City;
use common\model\town\Town;

class Base extends Common{

    public function index(){
        
    }

    public function addCity(){
        return $this->fetch('city/add');
    }

    public function editCity($id){
        $city = City::get($id);
        $this->assign('city',$city);
        return $this->fetch('city/edit');
    }

    public function doEditCity($id){

        $city = City::get($id);
        $city->city_name = $_POST['city_name'];
        $city->city_desc = $_POST['city_desc'];
        $cityId = $city->save();


        if($cityId){
            
            $this->success('修改成功','admin/cityList');
        }else{
            $this->error('修改失败');
        }
        
    }


    public function cityList(){
        $cityList = City::all();
        $this->assign('cityList',$cityList); 
        return $this->fetch('city/list');
    }


     public function doDelCity($id){

        $city = City::get($id);
        
        //删除县市会删除下面的乡镇
        $city->delCity(); 
       
        $result = $city->delete();
        
        if($result){
            $this->success('删除成功','admin/cityList');
        }else{
            $this->error('删除失败');
        }
        

     }    
    public function doAddCity(){

        $city = new City($_POST);
        // 过滤post数组中的非数据表字段数据
        $cityId = $city->allowField(true)->save();

        if($cityId){
            
            $this->success('添加成功','admin/cityList');
        }else{
            $this->error('添加失败');
        }
        
    }


    public function townList()
    {
         $city_List = City::all();

         foreach($city_List as $city){

             $city['townList'] = $city->town()->select();
             $city['townLen'] =$city->town()->count();
             
         }
       
        $this->assign('city_info',$city_List);
        return $this->fetch('town/list');

    }
     
    public function addTown()
    {

        $city_List = City::all();
        $this->assign('city_info',$city_List);
        return $this->fetch('town/add');

    }


    public function doAddTown()
    {
        $town = new Town($_POST);


        // 文件上传
        $file = request()->file('town_thumb');
        // 移动到框架应用根目录/public/uploads/ 目录下
        $info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
        if($info){

            $filePath =$info->getSaveName();
            $url = str_replace('\\','/',$filePath);

        }else{
            // 上传失败获取错误信息
            echo $file->getError();
        }

        $town->town_thumb = $url;

        // 过滤post数组中的非数据表字段数据
        $townId = $town->allowField(true)->save();

        if($townId){
            
            $this->success('添加成功','admin/townList');
        }else{
            $this->error('添加失败');
        }

    }
    
    public function townSign()
    {
        $town = new Town();
        $result = $town->getTownInfo(Cookie::get('manager_id'));
        $town_info=array(
            'id'=>$result->town_id,
            'desc'=>$result->town_desc,
            'name'=>$result->town_name
        );
        $this->assign('town_info',$town_info);
        
        return $this->fetch();
    }

    public function doEditTown(){
        $town = Town::get($_POST['town_id']);
        $town->town_desc = trim($_POST['town_desc']);
        $town->save();
        $this->redirect('admin');
    }
}