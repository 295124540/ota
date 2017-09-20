<?php
namespace app\api\controller\v1;

use app\common\controller\ActiveController;
use app\common\model\Collect;
use app\common\model\Users;
use think\Db;


class Book extends ActiveController
{
    protected $authenticate =  ['except'=>'index,read,category,search'];

    protected function findModel($id)
    {
        $model = parent::findModel($id);
        $model->read_num = $model->read_num +1;//阅读量+1
        $model->save();
        $model->model;
        foreach ($model->comment as $comment){
            $comment->reply;
        }
        $model['is_collect'] = false;
        $model->book_house;
        $model->book_donate; //捐书者
        foreach ( $model->book_rent as $rent){ //借阅者
            $user = Users::get($rent->user_id);
            if($user){
                $rent['head_img'] = $user['head_img_url'];
            }

        }
        if($this->userId){
            if(Collect::get(['type'=>2,'source_id'=>$id,'user_id'=>$this->userId])){
                $model['is_collect'] = true;
            }
        }
        return $model;
    }

    protected function prepareDataProvider()
    {
        $type = paramFromGet('type');
        if($type=='hot'){
            $this->order = 'read_num desc';
        }else{
            $this->order = 'create_time desc';
        }
        $list =  parent::prepareDataProvider();
        foreach ($list as $model){
            $model->model;
        }
        return $list;
    }


    /**
     * 分类书籍
     */
    public function category(){
        $categoryId = paramFromPost('category_id',true);
        $list = Db::query("SELECT b.id,m.name,m.cover_img FROM ot_book_model m,ot_book b WHERE b.model_id=m.id AND m.category_id =".$categoryId." LIMIT 50");
        success($list);
    }

    /**
     * 搜索
     */
    public function search($keyword){
        $model = new \common\model\Book();
        $list = $model->book()->where('name','like','%'.$keyword.'%')->select();
        if($list){
            success($list);
        }else{
            error("没有查询到该条件的书哦！");
        }
    }

}
