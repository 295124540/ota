<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/5/24
 * Time: 18:05
 */

namespace app\api\controller\v1;

use app\common\controller\ActiveController;
use app\common\model\Collect as CollectModel;
use think\Request;

class Collect extends ActiveController
{
    protected $modelClass = 'common\model\Collect';

    /**
     * 收藏列表
     */
    public function index()
    {
        $paras = Request::instance()->get();
        if($paras){
            $this->condition = $paras;
            $this->condition['user_id'] = $this->userId;
        }
        $list = $this->prepareDataProvider();
        foreach ($list as $model){
            if($model->type==1){
                $model->house;
            }
            if($model->type==2){
                if($model->book){
                    $model->book->model;
                }
            }
        }
        success($list);
    }

    /**
     * 收藏详情
     */
    public function read($id)
    {
        $this->condition['user_id'] = $this->userId;
        $model = $this->findModel($id);
        if($model->type==1){
            $model->house;
        }
        if($model->type==2){
            $model->book;
        }
        success($model);
    }

    /**
     * 收藏/取消收藏
     */
    public function save(){

        $params['source_id']=paramFromPost('source_id',true);
        $params['type']=paramFromPost('type',true);
        $params['user_id']=$this->userId;
        $m = CollectModel::get($params);
        if($m){
            $rt = $m->delete();
            if($rt){
                api(100,'成功取消收藏');
            }else{
                error('取消收藏失败');
            }
        }else{
            $m = CollectModel::create($params);
            if($m){
                api(100,"收藏成功！",$m);
            }else{
                error("收藏失败！");
            }
        }

    }

}