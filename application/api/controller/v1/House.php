<?php
namespace app\api\controller\v1;

use common\controller\ActiveController;
use common\model\Collect;

class House extends ActiveController
{

    protected $modelClass = 'common\model\House';

    protected $loginAuth = ['except'=>'index,read'];

    /**
     * 民宿列表（最新、随机推荐）
     */
    public function index(){
        $type = paramFromGet('type');
        if($type==1){ //0最新；1为推荐
            $modelClass = $this->modelClass;
            $list = $modelClass::order('RAND()')->limit(3)->select();
        }else{
            $list = $this->prepareDataProvider();
        }
        foreach ($list as $m){ //是否收藏
            $m['is_collect'] = false;
            if($this->userId){
                $rt = Collect::get(['source_id'=>$m->id,'type'=>1,'user_id'=>$this->userId]);
                if($rt){
                    $m['is_collect'] = true;
                }
            }
        }
        success($list);
    }

    /**
     * 详情
     * @param $id
     */
    public function read($id){
        $modelClass = $this->modelClass;

        $m = $modelClass::get($id);
        if($m){
            $m->img;
            $m->room;
            foreach ($m->room as $d){
                $d->img;
            }
            $m->support;
            foreach ($m->comment as $c){
                $c->reply;
            }

            success($m);
        }else{
            error("没有该ID的民宿哦！");
        }
    }


}
