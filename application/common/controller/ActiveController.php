<?php
namespace app\common\controller;
use common\model\Dynamic as DynamicModel;
use think\Request;

class ActiveController extends ApiBaseController
{

    protected $modelClass;
    protected $condition;
    protected $order;
    protected $with;//关联预载入

    /**
     * 初始方法
     */
    public function _initialize(){
        //api跨域
        header("Access-Control-Allow-Origin:*");
        header("Access-Control-Allow-Headers:Origin,X-Requested-With,Content-Type,Accept");
        header("Access-Control-Allow-Methods:DELETE,PUT");

        if ($this->modelClass == null) {
            $this->modelClass = 'app\common\model\\'.ucfirst(preg_replace('/[^>]+\./','',Request::instance()->controller()));//默认model
        }
        parent::_initialize();
    }

    /**
     * 保存动态
     */
    protected function saveDynamic($source_id,$type,$action=null,$location=null){
        if($this->user==null){
            return false;
        }
        $time = time();
        $m = DynamicModel::get(['source_id'=>$source_id,'type'=>$type]);
        if($m){
            if($action)$m->action = $action;
            if($location)$m->location = $location;
            $m->update_time = $time;
            $m->save();
            return true;
        }

        $param = [
            'user_id'=> $this->userId,
            'user_name'=> $this->user['nickname'],
            'user_head_img'=>$this->user['head_img_url'],
            'source_id'=>$source_id,
            'type'=>$type,
            'action'=>$action,
            'location'=>$location,
        ];
        $m = DynamicModel::create($param);
        if($m){
            return true;
        }else{
            return false;
        }
    }

    /**
     * find model
     * @param $id
     * @return mixed
     */
    protected  function findModel($id){

        $modelClass = $this->modelClass;
        $this->condition['id']=$id;
        $model = $modelClass::get($this->condition);

        if(!$model){
            error("你没权限操作或该记录已经被删除！");
        }
        return $model;
    }

    /**
     * find list
     * @return mixed
     */
    protected function prepareDataProvider(){
        $modelClass = $this->modelClass;

        // 条件
        if($this->condition){
            $query = $modelClass::where($this->condition);
        }

        // 排序
        if($this->order){
            if(isset($query)){
                $query = $query->order($this->order);
            }else{
                $query = $modelClass::order($this->order);
            }
        }

        // 关联预载入
        if($this->with){
            if(isset($query)){
                $query = $query->with($this->with);
            }else{
                $query = $modelClass::with($this->with);
            }
        }

        // 分页查询
        if(isset($query)){
            $list = $query->paginate(20);
        }else{
            $list = $modelClass::paginate(20);
        }
        return $list;
    }


    /**
     * 列表（分页）
     */
    public function index(){
        $list = $this->prepareDataProvider();
        success($list->toArray());
    }

    /**
     * 详情
     */
    public function read($id){
        $model = $this->findModel($id);
        if($model){
            success($model);
        }else{
            error("没有改ID的结果记录哦！");
        }

    }

    /**
     * 保存（新增）
     */
    public function save(){

        $param = $_POST;
        if($param == null)$param = json_decode(file_get_contents("php://input"),true);
        if($param == null)error("你没有提交参数哦！");

        $modelClass = $this->modelClass;
        $model = new $modelClass($param);
        $model->allowField(true)->save();

        if($model){
            success($model);
        }else{
            error($model->getError());
        }
    }

    /**
     * 修改
     */
    public function update($id){

        $param = request()->put();
        if($param == null)error("你没有提交参数哦！");

        $modelClass = $this->modelClass;
        $this->condition['id']=$id;
        $m = new $modelClass();
        $rt = $m ->allowField(true)->save($param, $this->condition);
        if($rt){
            success($m);
        }else{
            error("修改失败，你有可能没有修改任何参数！".$m->getError());
        }
    }

    /**
     * 删除
     */
    public function delete($id){

        $modelClass = $this->modelClass;
        $this->condition['id']=$id;
        $rt = $modelClass::destroy($this->condition);
        if($rt){
            success();
        }else{
            error($modelClass->getError);
        }
    }


}
